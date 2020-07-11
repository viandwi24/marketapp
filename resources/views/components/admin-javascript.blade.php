<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script>
    var Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 4000 });
    $(window).ready(function(){
    checklaststatepushmenu();
    });
    
    function togglepushmenu() {
        $state = !$('body').hasClass('sidebar-collapse');
        if ($state == true) {
            localStorage.setItem("pushmenu", false);
        } else {
            localStorage.setItem("pushmenu", true);
        }
    }
    function checklaststatepushmenu() {
        $state = localStorage.getItem("pushmenu");
        if ($state == null) {
            $state = true;
            localStorage.setItem("pushmenu", true);
        }
        if ($state == "false") {
            $('body').addClass('sidebar-collapse');
        }
    }
    const http = axios.create({
        baseURL: $('meta[name=base-url]').attr('content'),
        timeout: 1000,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-XSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        }
    });
    http.interceptors.response.use(function (res) {
        if (
            typeof res.data.status != "undefined"
            && typeof res.data.message != "undefined"
            && res.data.status == "success"
        )  toastr.success(res.data.message)
        return res;
    }, function (error) {
        let e = error.response;
        let text = e.statusText;
        if (typeof e.data.message != 'undefined') {
            text = e.data.message;

            if (e.status == 422 && typeof e.data.errors != "undefined") {
                let j = 0;                
                for (let i in e.data.errors) {
                    if (j == 0) text = e.data.errors[i][0];
                    j++;
                }
            }
        }
        toastr.error(text);
        return Promise.reject(error);
    });
</script>

@if (Session::has('alert'))
    <?php $alert = Session::get('alert'); ?>
    @if ($alert["type"] == 'success')
        <script>toastr.success(`{{ $alert['text'] }}`)</script>
    @elseif($alert["type"] == 'error')
        <script>toastr.error(`{{ $alert['text'] }}`)</script>
    @elseif($alert["type"] == 'info')
        <script>toastr.info(`{{ $alert['text'] }}`)</script>
    @endif
@endif

@if ($errors->any())
    <script>
    @foreach ($errors->all() as $error)
        console.log('{{ $error }}');
        toastr.error('{{ $error }}')
    @endforeach
    </script>
@endif