<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        return view('admin.agendas.index', ['items' => Agenda::orderByDesc('starts_on')->orderByDesc('id')->paginate(20)]);
    }

    public function create()
    {
        return view('admin.agendas.form', ['item' => new Agenda(['starts_on' => today()])]);
    }

    public function store(Request $r)
    {
        Agenda::create($this->data($r) + ['created_by' => $r->user()->id]);

        return redirect()->route('admin.agendas.index')->with('ok', 'Agenda disimpan.');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.form', ['item' => $agenda]);
    }

    public function update(Request $r, Agenda $agenda)
    {
        $agenda->update($this->data($r));

        return redirect()->route('admin.agendas.index')->with('ok', 'Agenda diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('admin.agendas.index')->with('ok', 'Agenda dihapus.');
    }

    private function data(Request $r): array
    {
        $v = $r->validate([
            'title' => ['required', 'string', 'max:200'],
            'starts_on' => ['required', 'date'],
            'ends_on' => ['nullable', 'date', 'after_or_equal:starts_on'],
            'time_text' => ['nullable', 'string', 'max:80'],
            'location' => ['nullable', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:2000'],
        ], [], ['title' => 'Nama agenda', 'starts_on' => 'Tanggal mulai', 'ends_on' => 'Tanggal selesai', 'time_text' => 'Jam', 'location' => 'Tempat', 'description' => 'Keterangan']);

        return [
            'title' => $v['title'], 'starts_on' => $v['starts_on'], 'ends_on' => $v['ends_on'] ?? null,
            'time_text' => $v['time_text'] ?? null, 'location' => $v['location'] ?? null, 'description' => $v['description'] ?? null,
        ];
    }
}
