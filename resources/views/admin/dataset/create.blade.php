@extends('layouts.admin')

@section('title', 'Tambah Dataset')
@section('subtitle', 'Buat dataset manual dengan wizard step-by-step')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-start justify-between gap-4 flex-col md:flex-row">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tambah Dataset</h1>
                <p class="text-slate-500 mt-1">Lengkapi informasi, susun kolom, lalu simpan dataset.</p>
            </div>
            <a href="{{ route('dataset.index') }}" class="px-4 py-2 rounded-xl border border-slate-300 text-sm hover:bg-slate-50">Kembali</a>
        </div>
    </div>

    <form method="POST" action="{{ route('dataset.store') }}" id="datasetForm">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="grid grid-cols-3 gap-3 mb-8" id="stepIndicator">
                <div class="step-pill active">1. Informasi</div>
                <div class="step-pill">2. Kolom</div>
                <div class="step-pill">3. Preview</div>
            </div>

            <div class="step-content" data-step="0">
                <div class="grid md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Nama Dataset <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" class="w-full rounded-xl border-slate-300 focus:ring-emerald-500" placeholder="Contoh: Data Pernikahan 2026">
                        <p class="text-xs text-red-500 mt-1 hidden" data-error="nama"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori_id" id="kategori_id" class="w-full rounded-xl border-slate-300">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-red-500 mt-1 hidden" data-error="kategori_id"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Seksi <span class="text-red-500">*</span></label>
                        <select name="seksi_id" id="seksi_id" class="w-full rounded-xl border-slate-300">
                            <option value="">Pilih Seksi</option>
                            @foreach($seksi as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-red-500 mt-1 hidden" data-error="seksi_id"></p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="w-full rounded-xl border-slate-300" placeholder="Deskripsi singkat dataset..."></textarea>
                    </div>
                </div>
            </div>

            <div class="step-content hidden" data-step="1">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="font-semibold text-slate-800">Struktur Kolom</h2>
                        <p class="text-sm text-slate-500">Tambahkan minimal satu kolom.</p>
                    </div>
                    <button type="button" onclick="addColumn()" class="px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700">+ Tambah Kolom</button>
                </div>

                <div id="columns-wrapper" class="space-y-3"></div>
                <p class="text-xs text-red-500 mt-2 hidden" data-error="kolom"></p>
            </div>

            <div class="step-content hidden" data-step="2">
                <div class="mb-4">
                    <h2 class="font-semibold text-slate-800">Preview Dataset</h2>
                    <p class="text-sm text-slate-500">Periksa rancangan tabel sebelum disimpan.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-100" id="previewHead"></thead>
                            <tbody id="previewBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-8 mt-8 border-t border-slate-200">
                <button type="button" id="backBtn" onclick="prevStep()" class="px-5 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-50 hidden">Back</button>
                <div class="ml-auto flex gap-2">
                    <button type="button" id="nextBtn" onclick="nextStep()" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700">Next</button>
                    <button type="submit" id="submitBtn" class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 hidden">Simpan Dataset</button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.step-pill{padding:.75rem 1rem;border-radius:1rem;background:#f1f5f9;color:#64748b;font-size:.875rem;font-weight:600;text-align:center}
.step-pill.active{background:#059669;color:white}
</style>

<script>
let currentStep = 0;
const totalSteps = 3;

function showStep(step){
    currentStep = step;
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
    document.querySelector(`.step-content[data-step="${step}"]`).classList.remove('hidden');

    document.querySelectorAll('.step-pill').forEach((el,i)=>{
        el.classList.toggle('active', i===step);
    });

    document.getElementById('backBtn').classList.toggle('hidden', step===0);
    document.getElementById('nextBtn').classList.toggle('hidden', step===2);
    document.getElementById('submitBtn').classList.toggle('hidden', step!==2);

    if(step===2) renderPreview();
}

function clearErrors(){
    document.querySelectorAll('[data-error]').forEach(e=>{e.textContent='';e.classList.add('hidden')});
}

function setError(name,msg){
    const el=document.querySelector(`[data-error="${name}"]`);
    if(el){el.textContent=msg;el.classList.remove('hidden');}
}

function validateStep(){
    clearErrors();
    if(currentStep===0){
        let ok=true;
        if(!nama.value.trim()){setError('nama','Nama dataset wajib diisi');ok=false;}
        if(!kategori_id.value){setError('kategori_id','Kategori wajib dipilih');ok=false;}
        if(!seksi_id.value){setError('seksi_id','Seksi wajib dipilih');ok=false;}
        return ok;
    }
    if(currentStep===1){
        const rows=document.querySelectorAll('.column-row');
        if(rows.length===0){setError('kolom','Minimal 1 kolom harus ditambahkan');return false;}
        let ok=true;
        rows.forEach((row,i)=>{
            const inp=row.querySelector('input');
            if(!inp.value.trim()) ok=false;
        });
        if(!ok) setError('kolom','Semua nama kolom wajib diisi');
        return ok;
    }
    return true;
}

function nextStep(){ if(validateStep()) showStep(currentStep+1); }
function prevStep(){ showStep(currentStep-1); }

function addColumn(name='',type='text'){
    const wrap=document.getElementById('columns-wrapper');
    const index=wrap.querySelectorAll('.column-row').length;
    const row=document.createElement('div');
    row.className='column-row grid md:grid-cols-12 gap-3 items-center';
    row.innerHTML=`
        <input name="kolom[${index}][name]" value="${name}" placeholder="Nama Kolom" class="md:col-span-7 rounded-xl border-slate-300 px-3 py-2 border">
        <select name="kolom[${index}][type]" class="md:col-span-4 rounded-xl border-slate-300 px-3 py-2 border">
            <option value="text">Text</option>
            <option value="number">Number</option>
            <option value="date">Date</option>
        </select>
        <button type="button" class="md:col-span-1 px-3 py-2 rounded-xl border text-red-600 hover:bg-red-50" onclick="this.parentElement.remove()">✕</button>`;
    wrap.appendChild(row);
    row.querySelector('select').value=type;
}

function renderPreview(){
    const names=[...document.querySelectorAll('.column-row input')].map(i=>i.value.trim()).filter(Boolean);
    const head=document.getElementById('previewHead');
    const body=document.getElementById('previewBody');

    if(names.length===0){
        head.innerHTML='<tr><th class="p-4 text-left">Belum ada kolom</th></tr>';
        body.innerHTML=''; return;
    }

    head.innerHTML='<tr>'+names.map(n=>`<th class="px-4 py-3 text-left font-semibold whitespace-nowrap">${n}</th>`).join('')+'</tr>';
    body.innerHTML='';
    for(let r=0;r<3;r++){
        body.innerHTML += '<tr class="border-t">'+names.map(()=>'<td class="px-4 py-3 text-slate-400">Sample Data</td>').join('')+'</tr>';
    }
}

addColumn();
showStep(0);
</script>
@endsection