<div class="modal fade" id="edit{{$product->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('products/'.$product->id ) }}" method="POST">
                                        @method('PUT')
										@csrf
                                        <div class="form-group">
                                            <label for="InputSection">اسم المنتج</label>
                                            <input type="text" class="form-control" id="InputSection" name="name" value="{{$product->name}}">
                                        </div>
                                        <select class="form-control" id="exampleFormControlSelect1" name="section_id">
                                            <option disabled selected>-- حدد القسم--</option>
                                            @foreach ($sections as $section)
                                                
                                            <option value="{{ $section->id }}"  {{ $section->id == $product->section_id ? 'selected' : '' }}>{{ $section->name }}</option>
                                            @endforeach
                                            
                                        </select>
                                        <div class="form-group">
                                            <label for="InputDesc">ملاحظات </label>
                                            <textarea type="text" class="form-control" id="InputDesc" name="description">{{$section->description}}</textarea>
                                        </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                    <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                                </div>
							</form>
                            </div>
                        </div>
                    </div>