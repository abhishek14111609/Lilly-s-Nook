<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::query()->latest();

        $status = $request->string('status')->toString();
        if ($status === 'unread') {
            $query->whereNull('read_at');
        } elseif ($status === 'read') {
            $query->whereNotNull('read_at');
        }

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($builder) use ($search): void {
                $builder->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('message', 'like', '%' . $search . '%');
            });
        }

        return view('admin.contact.index', [
            'messages' => $query->paginate(15)->withQueryString(),
            'unreadCount' => ContactMessage::query()->whereNull('read_at')->count(),
        ]);
    }

    public function show(ContactMessage $contactMessage): View
    {
        if ($contactMessage->read_at === null) {
            $contactMessage->forceFill(['read_at' => now()])->save();
        }

        return view('admin.contact.show', [
            'message' => $contactMessage,
        ]);
    }

    public function markRead(ContactMessage $contactMessage): RedirectResponse
    {
        if ($contactMessage->read_at === null) {
            $contactMessage->forceFill(['read_at' => now()])->save();
        }

        return redirect()->route('admin.contact-messages.index')->with('status', 'Inquiry marked as read.');
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')->with('status', 'Inquiry deleted successfully.');
    }
}
