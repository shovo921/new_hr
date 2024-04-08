@push('scripts')
    <script>        
        @if(session('success'))
        showBasicSweetAlert('success', '{{  session('success')}}')
        @endif
        
        @if($errors->any())
        <?php $html = '';?>
        @foreach ($errors->all() as $error)
        <?php $html .= $error.'. ';?>
        @endforeach
        showBasicSweetAlert('error', '{!! $html !!}')
        @endif
    </script>
@endpush