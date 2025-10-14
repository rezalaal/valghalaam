<div class="mx-4 mt-8">
    <h1 class="font-lalezar text-4xl">سفیران پویش</h1>
    @php    
        $headers = [
            ['key' => 'code', 'label' => 'کد سفیر'],
            ['key' => 'first_name', 'label' => 'نام'],
            ['key' => 'last_name', 'label' => 'نام خانوادگی'],
            ['key' => 'job_title', 'label' => 'شغل/پست']
        ];
    @endphp
    <x-table 
        :headers="$headers" 
        :rows="$users" 
        with-pagination
    />
</div>
