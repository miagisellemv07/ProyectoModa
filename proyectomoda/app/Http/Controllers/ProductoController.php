public function destroy(string $id)
{
    $producto = $this->productoDelEmprendedor($id);
    $producto->delete();

    return redirect()->route('productos.index')
        ->with('success', 'Producto eliminado correctamente.');
}