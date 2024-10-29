<div class="modal fade" id="edit{{$section->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">تعديل قسم</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('sections/'.$section->id ) }}" method="POST">
                                        @method('PUT')
										@csrf
                                        <div class="form-group">
                                            <label for="InputSection">اسم القسم</label>
                                            <input type="text" class="form-control" id="InputSection" name="name" value="{{$section->name}}">

                                        </div>
                                        <div class="form-group">
                                            <label for="InputDesc">ملاحظات </label>
                                            <textarea type="text" class="form-control" id="InputDesc" name="description">{{$section->description}}</textarea>
                                        </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                </div>
							</form>
                            </div>
                        </div>
                    </div>