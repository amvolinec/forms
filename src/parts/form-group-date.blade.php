                           <div class="form-group row">
                                <label for="state_id"
                                       class="col-md-4 col-form-label text-md-right">{{ __('%2$s') }}</label>
                                <div class="col-md-6">
                                    <datetime id="%1$s" type="date" name="%1$s" value="{{ $%4$s->%1$s ??  old('%1$s') }}"
                                              input-class="form-control @error('%1$s') is-invalid @enderror"
                                              format="yyyy-MM-dd" value-zone="UTC+3" %3$s></datetime>
                                </div>
                                @error('%1$s')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
