<div class="live-preview">
    <button class="btn btn-sm btn-success remove-item-btn"
        data-bs-toggle="modal"
        data-bs-target="#editeModel{{ $court->id}}">
        <i class='ri-pencil-fill align-bottom'></i>
    </button>
    <div class="modal fade" id="editeModel{{ $court->id}}" tabindex="-1" aria-labelledby="editeModel{{ $court->id}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">@lang('translation.addCourt')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/court/'.$court->id) }}" method='POST'>
                        @method("PUT")
                        {{ csrf_field() }}
                        <div class="row g-3">
                            <div class="col-xxl-6">
                                <div>
                                    <label for="name" class="form-label">@lang("translation.court")</label>
                                    <input type="text" name='name' class="form-control" id="name" value="{{$court->name}}" placeholder="@lang('translation.enterCourtName')">
                                </div>
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="location" class="form-label">@lang("translation.location")</label>
                                <input type="text" class="form-control" name='location' id="location" value='{{$court->location}}' placeholder="@lang('translation.enterLocation')">
                            </div><!--end col-->
                            <div class="col-xxl-6">
                                <label for="category" class="form-label">@lang("translation.category")</label>
                                <select name="category" value='{{ $court->category }}' id="category" class="form-select mb-3 text-capitalize"  aria-label="Default select example">
                                    @switch($court->category)
                                        @case('Centres des juges résidents')
                                            <option value='{{ $court->category }}'selected>@lang('translation.centerJudgeResi')</option>
                                            @break
                                        @case('cassation')
                                            <option value='{{ $court->category }}'selected>@lang('translation.cassation')</option>
                                            @break
                                        @case('appel de commerce')
                                            <option value='{{ $court->category }}'>@lang('translation.appelCommerce')</option>
                                            @break
                                        @case('appel de commerce')
                                            <option value='{{ $court->category }}'selected>@lang('translation.appelCommerce')</option>
                                            @break
                                        @case('appel')
                                            <option value='{{ $court->category }}'selected>@lang('translation.appel')</option>
                                            @break
                                        @case('commerciaux')
                                            <option value='{{ $court->category }}' selected>@lang('translation.commercial')</option>
                                            @break
                                        @case('administratifs')
                                            <option value='{{ $court->category }}'selected>@lang('translation.administratif')</option>
                                            @break
                                        @case('appel administratives')
                                            <option value='{{ $court->category }}'selected>@lang('translation.appelAdmin')</option>
                                            @break
                                        @default
                                            <option value='{{ $court->category }}' selected>@lang('translation.court')</option>
                                    @endswitch
                                    @foreach($category as $cat)
                                        @if($court->category != $cat)
                                            @switch($cat)
                                                @case('Centres des juges résidents')
                                                    <option value='{{ $cat }}'>@lang('translation.centerJudgeResi')</option>
                                                    @break
                                                @case('cassation')
                                                    <option value='{{ $cat }}'>@lang('translation.cassation')</option>
                                                    @break

                                                @case('appel de commerce')
                                                    <option value='{{ $cat }}'>@lang('translation.appelCommerce')</option>
                                                    @break
                                                @case('appel')
                                                    <option value='{{ $cat }}'>@lang('translation.appel')</option>
                                                    @break
                                                @case('commerciaux')
                                                    <option value='{{ $cat }}'>@lang('translation.commercial')</option>
                                                    @break
                                                @case('administratifs')
                                                    <option value='{{ $cat }}'>@lang('translation.administratif')</option>
                                                    @break
                                                @case('appel administratives')
                                                    <option value='{{ $cat }}'>@lang('translation.appelAdmin')</option>
                                                    @break
                                                @default
                                                    <option value='{{ $cat }}'>@lang('translation.court')</option>
                                            @endswitch
                                        @endif
                                    @endforeach
                                    <!-- <option value="première instance" {{ $court->category == '' ? 'selected' : ''}} >Première Instance</option>
                                    <option value="appel">Appel</option>
                                    <option value="Centres des juges résidents">Centres des juges résidents</option>
                                    <option value="appel de commerce">appel de commerce</option>
                                    <option value="commerciaux">commerciaux</option>
                                    <option value="appel administratives">appel administratives</option>
                                    <option value="administratifs">administratifs</option>
                                    <option value="cassation">cassation</option> -->
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