<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Pedido;
use App\Entity\PedidoProducto;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pedido')]
class PedidoController extends AbstractController
{
    #[Route('/finalizar', name: 'finalizar_pedido', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $productos = $entityManager->getRepository(Producto::class)->findAll();
        $usuario = $this->getUser();
        $pedido = new Pedido();
        $pedido->setUsuario($usuario);
        $pedido->setFecha(new \DateTime());

        foreach ($productos as $producto) {
            $cantidad = $request->request->get('cantidad_' . $producto->getId(), 0);
            if ($cantidad > 0) {
                $pedidoProducto = new PedidoProducto();
                $pedidoProducto->setPedido($pedido);
                $pedidoProducto->setProducto($producto);
                $pedidoProducto->setCantidad($cantidad);
                $entityManager->persist($pedidoProducto);
            }
        }

        $entityManager->persist($pedido);
        $entityManager->flush();

        $this->addFlash('success', 'Pedido finalizado con éxito.');

        return $this->redirectToRoute('mis_pedidos');
    }

    #[Route('/mis-pedidos', name: 'mis_pedidos')]
    public function misPedidos(EntityManagerInterface $entityManager): Response
    {
        $usuario = $this->getUser();
        $pedidos = $entityManager->getRepository(Pedido::class)->findBy(['usuario' => $usuario]);

        foreach ($pedidos as $pedido) {
            $precio = 0;
            foreach ($pedido->getPedidoProductos() as $pedidoProducto) {
                $precio += $pedidoProducto->getProducto()->getPrecio() * $pedidoProducto->getCantidad();
            }
            $pedido->setPrecioFinal($precio);
        }

        return $this->render('pedido/mis_pedidos.html.twig', [
            'pedidos' => $pedidos
        ]);
    }
    #[Route('/eliminar/{id}', name: 'eliminar_pedido', methods: ['DELETE'])]
    public function eliminarPedido(Pedido $pedido, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($pedido);
        $entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/actualizar/{id}', name: 'editar_pedido', methods: ['GET'])]
    public function actualizarPedido(Pedido $pedido, EntityManagerInterface $entityManager): Response
    {
        $productos = $entityManager->getRepository(Producto::class)->findAll();

        $idsPedido = [];

        foreach ($pedido->getPedidoProductos() as $pedidoProducto) {
            $idsPedido[] = $pedidoProducto->getProducto()->getId();
        }
        $productosRestantes = [];
        foreach ($productos as $producto) {
            if (!in_array($producto->getId(), $idsPedido)) {
                $productosRestantes[] = $producto;
            }
        }

        return $this->render('pedido/actualizar_pedido.html.twig', [
            'pedido' => $pedido,
            'productos' => $productosRestantes
        ]);
    }

    #[Route('/actualizar/{id}', name: 'actualizar_pedido', methods: ['POST'])]
    public function actualizarPedidoConfirm(Request $request, Pedido $pedido, EntityManagerInterface $entityManager): Response
    {
        $productos = $entityManager->getRepository(Producto::class)->findAll();
        $existeProducto = false;
        foreach ($pedido->getPedidoProductos() as $pedidoProducto) {
            $cantidad = $request->request->get('cantidadUpdate_' . $pedidoProducto->getId());
            if ($cantidad > 0) {
                $pedidoProducto->setCantidad($cantidad);
                $entityManager->persist($pedidoProducto);
                $existeProducto = true;
            } else {
                $entityManager->remove($pedidoProducto);
            }
        }

        foreach ($productos as $producto) {
            $cantidad = $request->request->get('cantidad_' . $producto->getId(), 0);
            if ($cantidad > 0) {
                $existeProducto = true;
                $pedidoProducto = new PedidoProducto();
                $pedidoProducto->setPedido($pedido);
                $pedidoProducto->setProducto($producto);
                $pedidoProducto->setCantidad($cantidad);
                $entityManager->persist($pedidoProducto);
            }
        }

        if (!$existeProducto) {
            $entityManager->remove($pedido);
        } else {
            $entityManager->persist($pedido);
        }

        $entityManager->flush();

        $this->addFlash('success', 'Pedido actualizado con éxito.');

        return $this->redirectToRoute('mis_pedidos');
    }
}
