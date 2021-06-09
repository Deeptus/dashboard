<?php print '<?php' ?>

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\<?php print $this->modelName ?>;

class MarcaController extends Controller
{
    public function index()
    {
        $data = <?php print $this->modelName ?>::get();
        return view('admin.marca.index', [
            'data'     => $data,
            '__admin_active' => 'admin.marca'
        ]);
    }

    public function create()
    {
        return view('admin.marca.create', [
            '__admin_active' => 'admin.marca'
        ]);
    }

    public function store(Request $request, $id = false)
    {
        if($id){
            $item = <?php print $this->modelName ?>::find($id);
        } else {
            $item = new Marca;
        }
        $item->nombre = $request->nombre;
        $item->save();
        return redirect()->route('admin.marca')->with('success', 'Se añadio una <strong>Marca</strong> con exitó.');
    }

    public function edit($id)
    {
        return view('admin.marca.edit', [
            'element' => <?php print $this->modelName ?>::find($id),
            '__admin_active' => 'admin.marca'
        ]);
    }

    public function destroy($id)
    {
        <?php print $this->modelName ?>::find($id)->delete();
        return redirect()->route('admin.marca', ['category_id' => request()->category_id])->with('success', 'Se ha eliminado un <strong>Marca</strong> con exitó.');
    }

    public function trash()
    {
        $data = <?php print $this->modelName ?>::onlyTrashed()->get();
        return view('admin.marca.index', [
            'data' => $data,
            'trash'=> true,
            '__admin_active' => 'admin.marca'
        ]);
    }

    public function restore($id)
    {
        $item = <?php print $this->modelName ?>::withTrashed()->find($id);
        $item->deleted_at = null;
        $item->save();
        return redirect()->route('admin.marca.trash', ['category_id' => request()->category_id])->with('success', 'Se ha restaurado un <strong>Marca</strong> con exitó.');
    }
}