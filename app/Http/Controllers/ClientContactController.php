<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ClientContactController extends Controller
{
    public function index()
    {
        return view('client.contact.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
            'message' => 'required|string',
        ]);

        // Custom messages
        $validator->messages()->add('name', 'Numele este necesar pentru a trimite mesajul.');
        $validator->messages()->add('email', 'Emailul este necesar pentru a trimite mesajul.');
        $validator->messages()->add('message', 'Adauga un mesaj corespunzator.');

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Mesajul a fost trimis!');
    }

    public function adminIndex()
    {
        $contacts = ContactUs::paginate(15);
        return view('admin.contact.index', compact('contacts'));
    }

    public function destroy(ContactUs $contact)
    {
        $contact->delete();
        return redirect()->back()->with('success', 'Mesajul a fost sters!');
    }
}
