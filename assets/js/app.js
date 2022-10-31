function string_to_slug (str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to   = "aaaaeeeeiiiioooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '_') // collapse whitespace and replace by -
        .replace(/-+/g, '_'); // collapse dashes

    return str;
}
function translit(word){
    var answer = '';
    var converter = {
        'а': 'a',    'б': 'b',    'в': 'v',    'г': 'g',    'д': 'd',
        'е': 'e',    'ё': 'e',    'ж': 'zh',   'з': 'z',    'и': 'i',
        'й': 'y',    'к': 'k',    'л': 'l',    'м': 'm',    'н': 'n',
        'о': 'o',    'п': 'p',    'р': 'r',    'с': 's',    'т': 't',
        'у': 'u',    'ф': 'f',    'х': 'h',    'ц': 'c',    'ч': 'ch',
        'ш': 'sh',   'щ': 'sch',  'ь': '',     'ы': 'y',    'ъ': '',
        'э': 'e',    'ю': 'yu',   'я': 'ya',

        'А': 'A',    'Б': 'B',    'В': 'V',    'Г': 'G',    'Д': 'D',
        'Е': 'E',    'Ё': 'E',    'Ж': 'Zh',   'З': 'Z',    'И': 'I',
        'Й': 'Y',    'К': 'K',    'Л': 'L',    'М': 'M',    'Н': 'N',
        'О': 'O',    'П': 'P',    'Р': 'R',    'С': 'S',    'Т': 'T',
        'У': 'U',    'Ф': 'F',    'Х': 'H',    'Ц': 'C',    'Ч': 'Ch',
        'Ш': 'Sh',   'Щ': 'Sch',  'Ь': '',     'Ы': 'Y',    'Ъ': '',
        'Э': 'E',    'Ю': 'Yu',   'Я': 'Ya'
    };

    for (var i = 0; i < word.length; ++i ) {
        if (converter[word[i]] == undefined){
            answer += word[i];
        } else {
            answer += converter[word[i]];
        }
    }

    return answer;
}

function hash_scroll() {
    $(document).ready(function(){
        var $page = $('html, body');
        $('a[href*="#"]').click(function() {
            $page.animate({
                scrollTop: $($.attr(this, 'href')).offset().top
            }, 200);
            return false;
        });
    });
}

$(document).ready(function(){
    var $page = $('html, body');
    $('a[href*="#"]').click(function() {
        $page.animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 200);
        return false;
    });
});

function geo_control(city_id) {
   
    $(document).on('change', '#country_select', function(){
        let countryID = parseInt($(this).val());
        $.ajax({
            method: 'GET',
            url: '?country='+countryID,
            dataType: 'html',
            error: function(){
                alert('Ошибка, страна не найден');
            },
            success: function(data) {
                var results = $('<div />').append(data).find('#regions_box').html();
                $('#regions_box').html(results);
                $('#cities_box').html('');
            }
        });
    });

    $(document).on('change', '#region_select', function(){
        let countryID = $('#country_select').val();
        let regionID = $(this).val();
        let queryUrl = '?region='+regionID+'&country='+countryID;
        $.ajax({
            method: 'GET',
            url: queryUrl,
            dataType: 'html',
            error: function(){
                alert('Ошибка, регион не найден');
            },
            success: function(data) {
                var results = $('<div />').append(data).find('#cities_box').html();
                $('#cities_box').html(results);
            }
        });
    });

}
$(document).ready(function(){
    $(document).on('change', '.reg-type-select', function(){
        if($(this).val() === 'invite_reg') {
            $('#invite_registration_mode_visible').addClass('visible');
        } else {
            $('#invite_registration_mode_visible').removeClass('visible');
        }
    });
});

function inputDelay(callback, ms) {
    var timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
        callback.apply(context, args);
        }, ms || 0);
    };
}

function ajaxSearchQuery(input, replacement, queryKey = 'query', queryType = 'POST', preloadClass = 'opacity-6', delayMs = 1000) {
    $(document).ready(function(){
        $(input).on('input', inputDelay(function(){
            let myQuery = $(input).val();
            let ajaxData = {};
            ajaxData[queryKey] = myQuery;
            $.ajax({
                type: queryType,
                data: ajaxData,
                dataType: 'html',
                beforeSend: function(){
                    $(replacement).addClass(preloadClass);
                },
                success: function(data){
                    let replacementData = $(data).find(replacement).html();
                    $(replacement).html(replacementData);
                    $(replacement).removeClass(preloadClass);
                }
            });
        }, delayMs));
    });
}


function outsideClick(elem)
{
    $(document).mouseup( function(e){ 
		var div = $(elem); 
		if ( !div.is(e.target)
		    && div.has(e.target).length === 0 ) {
			div.addClass('hidden');
		}
	});
}


function outsideClickCheckbox(elem, checkbox)
{
    $(document).mouseup( function(e){
		var div = $(elem);
		if (!div.is(e.target) && div.has(e.target).length === 0) { 
            $(checkbox).prop('checked', false);
		}
	});
}


function getLocations(input, list, listItem, cityInput)
{
    let myQuery = $(input).val();
    let ajaxData = {};
    ajaxData['location'] = myQuery;
    $.ajax({
        type: 'GET',
        data: ajaxData,
        dataType: 'html',
        url: '/api/get_location',
        beforeSend: function(){
            $(list).removeClass('hidden');
            $(list).html('<span class="preloader flex flex-center w100 h100"><i class="fas fa-spinner"></i></span>');
        },
        success: function(data){
            $(list).html(data);
            $(listItem).on('click', function(){
                $(list).addClass('hidden');
                $(input).val($(this).text());
                $(cityInput).val($(this).attr('data-id'));
            });
        }
    });
}

function buttonPreloader(button)
{
    $(button).html('<span class="preloader button-preloader"><i class="fas fa-spinner"></i></span>');
}


function resendCodeTime(resendLink, resendTime, resendTimeValue, time = 60)
{
    $(resendLink).on('click', function(e){
        e.preventDefault();
        $(resendLink).addClass('hidden');
        $(resendTime).removeClass('hidden');
        $(resendTimeValue).text(time);
        let timeInterval = setInterval(function(){
            let currentTime = Number($(resendTimeValue).text());
            if(currentTime > 0) {
                let newTime = currentTime-1;
                $(resendTimeValue).text(newTime);
            } else {
                $(resendLink).removeClass('hidden');
                $(resendTime).addClass('hidden');
                clearInterval(timeInterval);
            }
        }, 1000);
    });
  
}


function setRating(starElem = '.rating-star', greenStarClass = 'green-star', ratingValueElem = '#rating_value', rateInputElem = '#review_rate_js')
{
    $(document).ready(function(){
        $(starElem).on('mouseover', function(){
            $(starElem).removeClass(greenStarClass);
            let id = Number($(this).attr('data-rate'));
            setCurrentRate(starElem, greenStarClass, id);
        });
        $(starElem).on('mouseout', function(){
            $(starElem).removeClass(greenStarClass);
            let currentRate = $(rateInputElem).val();
            if(currentRate) {
                setCurrentRate(starElem, greenStarClass, currentRate); 
            }
        });
        $(starElem).on('click', function(){
            let id = Number($(this).attr('data-rate'));
            let currentRate = Number($(rateInputElem).val());
            if(id === currentRate) {
                $(starElem).removeClass(greenStarClass);
                $(ratingValueElem).text('');
                $(rateInputElem).val('');
                return;
            }
            $(ratingValueElem).text(id);
            $(rateInputElem).val(id);
            setCurrentRate(starElem, greenStarClass, id);
        });
    });
}

function setCurrentRate(starElem, greenStarClass, currentRate)
{
    while(currentRate > 0) {
        $(starElem+'[data-rate="'+currentRate+'"]').addClass(greenStarClass);
        currentRate--;
    }
}

function linkCopy(){
    $(".link-label").click(function() {
        $(this).find(".form-control").select();
        navigator.clipboard.writeText($(this).find(".form-control").val()).then(() => {
            $(this).find('.copy-info').addClass('active');
        });
        setTimeout(function(){
            $('.copy-info').removeClass('active');
        }, 2000);
    });
    $(".form-control").click(function() {
        $(this).select();
        navigator.clipboard.writeText($(this).val()).then(() => {
            $(this).parent().parent().find('.copy-info').addClass('active');
        });
        setTimeout(function(){
            $('.copy-info').removeClass('active');
        }, 2000);
    });
}


$(document).ready(function(){
    $('.date').mask('00/00/0000');
    $('.date-dot').mask('00.00.0000');
    $('.time').mask('00:00:00');
    $('.time_range').mask('Hh:Mm - Hh:Mm', {
        translation: {
            // '00:00': {
            //     pattern: /^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/
            // },
            'H': {
                pattern: /^[0-2]/
            },
            'h': {
                pattern: /^[0-9]/
            },
            'M': {
                pattern: /^[0-5]/
            },
            'm': {
                pattern: /^[0-9]/
            }
        }
        // onKeyPress: function(val, e, field, options) {
        //     let newval = val.replace(/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9] - (0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/, '');
        //     console.log(newval);
        //     // field.val(newval);
        // }
    });
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.phone').mask('+0#');
    $('.money').mask('000 000 000 000.00', {reverse: true});
    $('.rating').mask('Z.00', {
        translation: {
            'Z': {
                pattern: /[0-5]/
            }
        }
    });
      
    $('.ceil_percent').mask('000', {
        onKeyPress: function(cep, e, field, options) {
            if(Number(cep) > 100) {
                field.val(100);
            }
        }
    });

    // $('.ceil_percent').mask('000', {
    //     regex:  /^[1-9][0-9]?$|^100$/
    // });
    // $('.cep').mask('00000-000');
    // $('.phone').mask('0000-0000');
    // $('.phone_with_ddd').mask('(00) 0000-0000');
    // $('.phone_us').mask('(000) 000-0000');
    // $('.mixed').mask('AAA 000-S0S');
    // $('.cpf').mask('000.000.000-00', {reverse: true});
    // $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    // $('.money').mask('000.000.000.000.000,00', {reverse: true});
    // $('.money2').mask("#.##0,00", {reverse: true});
    // $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
    //   translation: {
    //     'Z': {
    //       pattern: /[0-9]/, optional: true
    //     }
    //   }
    // });
    // $('.ip_address').mask('099.099.099.099');
    // $('.percent').mask('##0,00%', {reverse: true});
    // $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
    // $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
    // $('.fallback').mask("00r00r0000", {
    //     translation: {
    //       'r': {
    //         pattern: /[\/]/,
    //         fallback: '/'
    //       },
    //       placeholder: "__/__/____"
    //     }
    //   });
    // $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
  });

