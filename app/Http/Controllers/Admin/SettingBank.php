<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Models\Bank;
use App\Models\DataBank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingBank extends Controller
{
    public function __construct()
    {
        $this->middleware("adminMiddle");
    }

    public function index()
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $DataTabel = DataBank::paginate(10);

        $data = array_merge($user, $website, [
            "page" => "Setting Bank",
            "DataTabel" => $DataTabel,
        ]);
        $data["bank"] = Bank::where("type", "bank")->get();
        $data["emoney"] = Bank::where("type", "emoney")->get();

        return view("admin.setting-bank", $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "bank" => "required",
            "nama_rek" => "required",
            "no_rek" => "required",
        ]);

        // Update the values based on the desired keys
        $value["nama_rek"] = $validatedData["nama_rek"];
        $value["no_rek"] = $validatedData["no_rek"];

        $data = new DataBank();
        $data->key = $validatedData["bank"];
        $data->value = json_encode($value);
        $data->save();

        return redirect()
            ->back()
            ->with("success", "User data updated successfully");
    }

    public function update(Request $request)
    {
        // Retrieve the bank data from the request
        $id = $request->input("id");
        $data = DataBank::where("id", $id)->first();
        $value = json_decode($data->value, true); // Decode JSON data into an array

        // Update the values based on the desired keys=
        $bank = $request->input("bank");
        $value["nama_rek"] = $request->input("nama_rek");
        $value["no_rek"] = $request->input("no_rek");

        $data->update(["key" => $bank, "value" => json_encode($value)]);

        // Redirect or return a response
        return redirect()
            ->back()
            ->with("success", "User data updated successfully");
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $bank = DataBank::findOrFail($id);
        $bank->delete();

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }

    public function Ajax(Request $request)
    {
        $DataTabel = DataBank::paginate(10);
        $partialView = view(
            "admin.partial.setting-bank",
            compact("DataTabel")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function get_setting_bank(Request $request)
    {
        $id = $request->input("id");

        $query = DataBank::query();
        $bank = $query->where("id", $id)->first();
        $value = $bank ? json_decode($bank->value, false) : null;

        // Return the partial view as JSON response
        return response()->json(["bank" => $bank, "value" => $value]);
    }
}
