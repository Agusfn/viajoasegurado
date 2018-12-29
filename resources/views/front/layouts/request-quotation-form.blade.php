{{ Form::open( array("url" => uri_localed("quotation/create"), "method" => "post", "id" => "quote-form") ) }}
    
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group form-group-lg form-group-icon-left">
                <i class="fa fa-map-marker input-icon"></i>
                <label>Desde</label>
                <input type="text" class="typeahead form-control" id="country-from-input" placeholder="País" data-provide="typeahead" autocomplete="off" />
                <input type="hidden" name="country_code_from">
                <label class="form-error" id="country-from-error">Selecciona un país válido</label>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-group-lg form-group-icon-left">
                <i class="fa fa-map-marker input-icon"></i>
                <label>Hacia</label>
                <select class="form-control" name="region_code_to">
                    <option>Seleccionar</option>
                    @foreach($regions_to as $region)
                    <option value="{{ $region["id"] }}">{{ $region["name"] }}</option>
                    @endforeach
                </select>
                <label class="form-error" id="region-to-error">Selecciona un destino</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group form-group-lg form-group-icon-left">
                <i class="fa fa-calendar input-icon input-icon-highlight"></i>
                <label>Fecha salida</label>
                <input class="form-control" name="date_start" type="text" data-date-format="dd/mm/yyyy" data-date-language="{{ \App::getLocale() }}" />
                <label class="form-error" id="date-start-error">Selecciona una fecha válida mayor a hoy</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group form-group-lg form-group-icon-left">
                <i class="fa fa-calendar input-icon input-icon-highlight"></i>
                <label>Fecha vuelta</label>
                <input class="form-control" name="date_end" type="text" data-date-format="dd/mm/yyyy" data-date-language="{{ \App::getLocale() }}" />
                <label class="form-error" id="date-end-error">Selecciona una fecha válida después de la fecha de salida</label>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group" style="padding-top: 28px">
                <label><input type="checkbox" class="icheckbox" name="travel_pregnant"> El seguro es para una mujer embarazada</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-lg">
                <label>Pasajeros</label>
                <div class="btn-group btn-group-select-num" data-toggle="buttons">
                    <label class="btn btn-primary active" id="passg-ammt-1">
                        <input type="radio" name="passenger_ammount" value="1" />1
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="passenger_ammount" value="2" />2
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="passenger_ammount" value="3" />3
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="passenger_ammount" value="4" />4
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="passenger_ammount" value="5" />5
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="form-group form-group-lg" style="padding-left: 15px">
                    <label>Edades</label>
                    <input type="text" class="form-control short-input" name="age1" id="age1-input" maxlength="2">&nbsp;
                    <input type="text" class="form-control short-input" name="age2" id="age2-input" maxlength="2" style="display: none;">&nbsp;
                    <input type="text" class="form-control short-input" name="age3" id="age3-input" maxlength="2" style="display: none;">&nbsp;
                    <input type="text" class="form-control short-input" name="age4" id="age4-input" maxlength="2" style="display: none;">&nbsp;
                    <input type="text" class="form-control short-input" name="age5" id="age5-input" maxlength="2" style="display: none;">&nbsp;
                    <label class="form-error" id="ages-error">Ingresa edades válidas</label>
                </div>
                <div class="col-xs-7 form-group form-group-lg" id="gestation-weeks-form-group">
                    <label>Semanas de gestación</label>
                    <input type="text" name="gestation_weeks" class="form-control short-input" maxlength="2">
                    <label class="form-error" id="gest-weeks-error">Ingresa un número válido</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-lg">
                <label>E-mail</label>
                <input type="text" class="form-control" name="email">
                <label class="form-error" id="email-error">Ingresa una dirección e-mail válida</label>
            </div>
        </div>
        <div class="col-md-6" style="text-align: right;">
            <button type="button" class="btn btn-primary btn-lg" id="submit-quote-btn" style="margin-top: 27px">Cotizar</button>
        </div>
    </div>


    
{{ Form::close() }}