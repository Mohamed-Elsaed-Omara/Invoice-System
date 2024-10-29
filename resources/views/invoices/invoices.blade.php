@extends('layouts.master')
@section('title')
    قائمة الفواتير
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: 'تم حذف الفاتورة بنجاح',
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('status_update'))
        <script>
            window.onload = function() {
                notif({
                    msg: 'تم تغير حالة الدفع بنجاح',
                    type: "success"
                })
            }
        </script>
    @endif
	
    @if (session()->has('invoice_archive'))
        <script>
            window.onload = function() {
                notif({
                    msg: 'تم نقل الفاتورة الي الارشيف بنجاح',
                    type: "success"
                })
            }
        </script>
    @endif
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    @can('اضافة فاتورة')
                        
                    <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                        class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>
                    @endcan

                            <a class="modal-effect btn btn-sm btn-primary" href="{{ url('users/export') }}"
                            style="color:white"><i class="fas fa-file-download"></i>&nbsp;تصدير اكسيل</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                    <th class="wd-20p border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="wd-15p border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="wd-10p border-bottom-0">المنتج</th>
                                    <th class="wd-25p border-bottom-0">القسم</th>
                                    <th class="wd-25p border-bottom-0">الخصم</th>
                                    <th class="wd-25p border-bottom-0">نسبة الضريبة</th>
                                    <th class="wd-25p border-bottom-0">قيمة الضريبة</th>
                                    <th class="wd-25p border-bottom-0"> الاجمالي</th>
                                    <th class="wd-25p border-bottom-0"> الحالة</th>
                                    <th class="wd-25p border-bottom-0"> ملاحظات</th>
                                    <th class="wd-25p border-bottom-0"> العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                ?>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>

                                            <a href="{{ url('invoice-details/' . $invoice->id) }}">

                                                {{ $invoice->section->name }}
                                            </a>
                                        </td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vat }}</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @if ($invoice->status == App\Models\Invoice::PAID)
                                                <span class="text-success">{{ $invoice->status_text }}</span>
                                            @elseif ($invoice->status == App\Models\Invoice::UNPAID)
                                                <span class="text-danger">{{ $invoice->status_text }}</span>
                                            @else
                                                <span class="text-warning">{{ $invoice->status_text }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $invoice->note }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">

                                                    {{-- <a class="dropdown-item"
                                                        href=" {{ url('edit_invoice') }}/{{ $invoice->id }}">تعديل
                                                        الفاتورة</a>
 --}}
                                                    <a class="dropdown-item" onclick="confirmation(event)"
                                                        href="{{ url('del-invoice/' . $invoice->id) }}"> <i
                                                            class="text-danger fas fa-trash-alt"></i> حذف الفاتورة </a>

                                                    <a class="dropdown-item"
                                                        href="{{ url('payment-change/' . $invoice->id) }}"><i
                                                            class=" text-success fas fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                        حالة
                                                        الدفع</a>


                                                    <a type="button" class="dropdown-item" data-toggle="modal"
                                                        data-target="#exampleModal{{ $invoice->id }}">
                                                        <i class="text-warning fas fa-exchange-alt"></i>
                                                        نقل الي الارشيف
                                                    </a>

                                                    <a class="dropdown-item" href="{{ url('print_invoice/' . $invoice->id )}}"><i
																		class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
																	الفاتورة
																</a>

                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <div class="modal fade" id="exampleModal{{ $invoice->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
													<form action="{{ url('invoice-archive/' . $invoice->id) }}" method="POST">
														@csrf
                                                    هل انت متاكد من عملية الارشفة ؟
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">اغلاق</button>
                                                    <button type="submit" class="btn btn-success">تاكيد</button>
                                                </div>
											</form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script type="application/javascript">


	function confirmation(ev){

	
		ev.preventDefault();
			var urlToRedirect = ev.currentTarget.getAttribute('href');

			console.log(urlToRedirect);

			swal({
				title: "هل انت متأكد من حذف الفاتورة ",
				icon: "warning",
				buttons: true,
				dangerMode: true,

				})
				.then((willCancel)=>
				{
					if(willCancel)
					{
						window.location.href = urlToRedirect;
					}
				});
			}

	</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
