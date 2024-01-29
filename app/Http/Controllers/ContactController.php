<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactRequestForm;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::where('user_id', auth()->user()->id)->paginate(5);

        return view('contact.index', compact(['contacts']));
    }

    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:contacts,name',
            'company_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:contacts,email'
        ]);

        $request['user_id'] = auth()->user()->id;

        Contact::create($request->all());

        return redirect()->route('contact.index')->with('success', 'Contact has been saved!');
    }

    public function edit(Contact $contact)
    {
        if (auth()->user()->id !== $contact->user_id)
            abort('403', 'Unauthorized Access');

        return view('contact.edit', compact(['contact']));
    }

    public function update(Contact $contact, UpdateContactRequest $updateContactRequest)
    {
        if (auth()->user()->id != $contact->user_id)
            abort('403', 'Unauthorized Access');

        $contact->update($updateContactRequest->all());


        return redirect()->route('contact.index')->with('success', 'Contact has been updated!');
    }

    public function destroy(Request $request)
    {
        $contact = Contact::find($request->contact_id);

        if (auth()->user()->id != $contact->user_id)
            abort('403', 'Unauthorized Access');

        $contact->delete();

        return redirect()->route('contact.index')->with('success', 'Contact has been deleted!');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';

            $contacts = Contact::where('name', 'like', '%' . $request->search . '%')
                ->orWhere('company_name', 'like', '%' . $request->search . '%')
                ->orWhere('phone_number', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->paginate(10);

            if ($contacts) {
                return $contacts;
            }

            return response($output);
        }
    }
}
