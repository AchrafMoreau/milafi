<div class="live-preview">
    <button class="btn btn-sm btn-success remove-item-btn"
        data-bs-toggle="modal"
        data-bs-target="#editeModel{{ $judge->id}}">
        <i class='ri-pencil-fill align-bottom'></i>
    </button>
    <div class="modal fade" id="editeModel{{ $judge->id}}" tabindex="-1" aria-labelledby="editeModel{{ $judge->id}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">@lang('translation.addJudge')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/judge/'.$judge->id) }}" method='POST'>
                        @method("PUT")
                        {{ csrf_field() }}
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="name" class="form-label">@lang("translation.fullName")</label>
                                    <input type="text" name='name' class="form-control" id="name" value="{{$judge->name}}" placeholder="@lang('translation.enterFullName')">
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <label class="form-label">@lang("translation.gender")</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"  {{ $judge->gender == "Male" ? 'checked' : "" }} type="radio" name="gender" id="inlineRadio1" value="male">
                                        <label class="form-check-label"  for="inlineRadio1">@lang('translation.male')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" {{ $judge->gender == "Female" ? 'checked' : "" }} type="radio" name="gender" id="inlineRadio2" value="female">
                                        <label class="form-check-label" for="inlineRadio2">@lang('translation.female')</label>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="contact_info" class="form-label">@lang("translation.contact")</label>
                                <input type="texth" class="form-control" name='contact_info' id="contact_info" value='{{$judge->contact_info}}' placeholder="@lang('translation.enterContact')">
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="choices-single-default" class="form-label m-0 p-0">
                                        @lang('translation.court')
                                </label>
                                <select  data-choices name="court" 
                                id="choices-single-default"  class='form-control ' >
                                    <option value="{{ $judge->court->id }}" >{{ $judge->court->name }}</option>
                                    @foreach($courts  as $court)
                                        @if($court->id != $judge->court->id)
                                            <option value="{{ $court->id }}" >{{ $court->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang("translation.close")</button>
                                    <button type="submit" class="btn btn-success">@lang("translation.edit")</button>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>