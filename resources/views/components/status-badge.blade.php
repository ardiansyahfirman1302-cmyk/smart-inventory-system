@props(['status' => 'active'])

@php
    $map = [
        // generic
        'active'      => ['label' => 'Aktif',     'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-200'],
        'inactive'    => ['label' => 'Nonaktif',  'class' => 'bg-slate-100 text-slate-600 ring-slate-200'],
        // stock
        'in_stock'    => ['label' => 'In Stock',      'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-200'],
        'low_stock'   => ['label' => 'Low Stock',     'class' => 'bg-amber-50 text-amber-700 ring-amber-200'],
        'out_of_stock'=> ['label' => 'Out of Stock',  'class' => 'bg-rose-50 text-rose-700 ring-rose-200'],
        // maintenance
        'pending'     => ['label' => 'Pending',       'class' => 'bg-slate-100 text-slate-700 ring-slate-200'],
        'in_progress' => ['label' => 'In Progress',   'class' => 'bg-sky-50 text-sky-700 ring-sky-200'],
        'completed'   => ['label' => 'Completed',     'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-200'],
        'cancelled'   => ['label' => 'Cancelled',     'class' => 'bg-rose-50 text-rose-700 ring-rose-200'],
        // priority
        'low'         => ['label' => 'Low',    'class' => 'bg-slate-100 text-slate-700 ring-slate-200'],
        'medium'      => ['label' => 'Medium', 'class' => 'bg-sky-50 text-sky-700 ring-sky-200'],
        'high'        => ['label' => 'High',   'class' => 'bg-amber-50 text-amber-700 ring-amber-200'],
        'urgent'      => ['label' => 'Urgent', 'class' => 'bg-rose-50 text-rose-700 ring-rose-200'],
    ];
    $m = $map[$status] ?? ['label' => ucfirst(str_replace('_',' ',$status)), 'class' => 'bg-slate-100 text-slate-700 ring-slate-200'];
@endphp

<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wide ring-1 {{ $m['class'] }}">
    {{ $m['label'] }}
</span>
