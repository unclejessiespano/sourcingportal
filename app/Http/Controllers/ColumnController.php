<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Column;
use App\Models\Column_Map;
use App\Models\SupplierColumnMap;
use App\Models\Supplier;
class ColumnController extends Controller
{
    public function mapcolumn(Request $request){
        Column_Map::mapColumn($request);
        return false;
    }
    public function mapcolumns()
    {
        $columns = Column::getColumns();
        return Inertia::render('Mapcolumns', ['columns'=>$columns]);
    }
    public function mapcolumnssupplier(Request $request){
        $supplier = Supplier::find($request->supplier_id);
        $columns = Column::getColumns();
        $json = Column::makeSupplierColumnMap($columns, $request->columns);
        if(SupplierColumnMap::addSupplierColumnMap($request->supplier_id, $json)){
            return redirect()->route('supplier.openorders', ['slug'=>$supplier->slug]);
        }
        return false;
    }
}
