<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Helpers\OptionsHelper;
class MenuController extends Controller
{
    public function index() {
        $menus = Menu::latest()->paginate(5);
        return view('admin.menu.index',['menus'=> $menus]);
    }

    public function create() {
        $rootMenus = Menu::where('parent_id', 0)->get();
        // Generate options for the dropdown
        $options = OptionsHelper::generateOptions($rootMenus);
        return view('admin.menu.add',['options' => $options]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'parent_id' => 'required|integer',
        ]);

// Create a new menu record using the create method
        $menu = Menu::create([
            'name' => $validatedData['name'],
            'parent_id' => $validatedData['parent_id'],
            // Add more fields as needed
        ]);

// Redirect to the index page after creating the menu record
        return redirect(route('menus.index'));
    }

    public function edit($id) {
        $menu = Menu::findOrFail($id);

        $rootMenus = Menu::where('parent_id', 0)->get();

        // Generate options for the dropdown
        $options = OptionsHelper::generateOptions($rootMenus, $menu);

        return view('admin.menu.edit',['menu'=> $menu, 'options' => $options ]);
    }

    public function update(Request $request, $id) {
        $menu = Menu::findOrFail($id);
//        dd($category);
        $validatedData = $request->validate([
            'name' => 'required|string',
            'parent_id' => 'required|integer',
        ]);
        $menu->update([
            'name' => $validatedData['name'],
            'parent_id' => $validatedData['parent_id'],
            // Add more fields as needed
        ]);

        $menu->save();
        return redirect(route('menus.edit',['id'=>$id]));
    }

    public function delete($id) {
        $menu = Menu::findOrFail($id);
        if ($menu->children()->exists()) {
            return back()->with('error', 'Cannot delete menu with children. Please delete all children first.');
        }
        $menu->delete();
        return redirect(route('menus.index'));
    }


}
