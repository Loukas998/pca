<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Mockery\Matcher\Contains;

class ContactUsController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->ok('Contact-Us', ContactUs::all());
    }

    public function store(Request $request)
    {
        $contact = ContactUs::create($request->all());
        return $this->ok('Contact-Us', $contact);
    }

    public function show($id)
    {
        $contact = ContactUs::find($id);
        return $this->ok('Contact-Us', $contact);
    }

    public function update(Request $request, $id)
    {
        $contact = ContactUs::find($id);
        if($contact)
        {
            $contact->update($request->all());
            return $this->noContent('Updated');
        }
        return $this->error('Not Found', 404);
    }

    public function destroy($id)
    {
        $contact = ContactUs::find($id);
        if($contact)
        {
            $contact->delete();
            return $this->noContent('Deleted');
        }
        return $this->error('Not Found', 404);
    }
}
