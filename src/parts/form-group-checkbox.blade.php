                        <div class="mb-3 row">
                            <div class="col-md-4"></div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input id="%1$sCheck" type="checkbox" class="form-check-input" name="%1$s"%3$s @if(isset($%4$s) && $%4$s->%1$s && $%4$s->%1$s === 1) checked @endif>
                                    <label class="form-check-label" for="%1$sCheck">{{ __('%2$s') }}</label>
                                </div>
                            </div>
                        </div>
