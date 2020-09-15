                            <div class="form-group row">
                                <label for="%1$s" class="col-md-4 col-form-label text-md-right">{{ __('%2$s') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="%1$s" id="%1$s" %3$s>
                                        <option value="" disabled selected>{{ __('Select your option') }}</option>
                                        @foreach($%5$s as $item)
                                            <option value="{{ $item->id }}"
                                                    @if(isset($%4$s) && $item->id === $%4$s->%1$s) selected @endif>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
