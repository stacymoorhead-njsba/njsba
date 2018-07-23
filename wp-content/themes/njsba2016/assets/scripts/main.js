(function($) {

// responsive nav js plugin
  var nav = responsiveNav(".nav-collapse", {
    customToggle: "main-nav__toggle",
    open: function(){
      $('.header-search__form').removeClass('header-search--show').addClass('header-search--hide');
    }
  });
  
  // site header search toggle
  $('.header-search__form').addClass('header-search--hide');
  $('.header-search__toggle').on('click', function() {
    nav.close();
    $('.header-search__form').toggleClass('header-search--hide').toggleClass('header-search--show');
    $('.header-search__input').focus();
  });

  // scroll promt hide
  var $document = $(document),
    $element = $('#scroll-prompt'),
    className = 'has-scrolled';
    
  // upon page load
  if ($document.scrollTop() <= 150) {
    $element.show();
  } else {
    $element.addClass(className);
  }

  $document.scroll(function() {
    $element.show();
    if ($document.scrollTop() >= 150) {
      // user scrolled x pixels or more;
      // do stuff
      $element.addClass(className);
    } else {
      $element.removeClass(className);
    }
  });

})(jQuery); // Fully reference jQuery after this point.




//for the fsr widget

//all district list
function style_replace(el, att, search_data){
  
  //get the css
    var searchCSS = el;
    var search_style = searchCSS.innerHTML;
  
  //find the replaceable var
    var js_replace = searchCSS.getAttribute(att);
    
  //replace it
    search_style = search_style.replace(new RegExp(js_replace, 'g'), search_data);
    
    searchCSS.setAttribute(att, search_data);

    searchCSS.innerHTML = search_style;

}


/* Adds change button for fsr widget, to go back to a normal screen */
function fsr_reset_button(el){
  
  el.addEventListener('click', function(){

      var fsr = el.parentNode;      
      while ( fsr.getElementsByTagName('style').length === 0 ) {
        fsr = fsr.parentNode;
      }
      
      var fsr_input = fsr.getElementsByTagName('input')[0];
      var fsr_css = fsr.getElementsByTagName('style')[0];
      fsr_input.value = '';
      fsr_input.focus();
      style_replace(fsr_css, 'data-replace' ,'JS_REPLACE');

  });

}

/* actually go get a representative */
function fsr_search_form_submit(el){

  el.addEventListener('submit', function(event){
    event.preventDefault();
    //get the input
     var fsr_input = el.getElementsByClassName('js_fsr-search__input')[0];
     var v = '-'+fsr_input.value.toLowerCase();
     var search_style = el.parentNode.getElementsByTagName('style')[0];
     style_replace(search_style , 'data-replace', v);

  });


}


/*

reset buttons require a data-search-css attribute
and the value of it is the id of the style you want
data-search-css="js_fsr-search__css"

*/

//create the new cards of the new people

function build_fsr_cards(people){

var fsr_search_widgets = document.querySelectorAll('.js_fsr_search');

if(fsr_search_widgets.length > 0){

people = people.people;



for (var i = 0; i < fsr_search_widgets.length; i++) {  
  var widget = fsr_search_widgets[i];
  var D = [];

  //holding contianer for the new cards
  var cards = document.createElement('div');
  //card template
  var card_template = widget.getElementsByClassName('js_contact_card')[0];
  
  //card parent
  var parent = card_template.parentNode;

for (var pp = 0; pp < people.length; pp++) {

    var person = people[pp];
    //var districts = person.fsr[0].district;


    //var person_districts = [];
    var districts = [];
    var all_counties = person.fsr;
    

    for (var c = all_counties.length - 1; c >= 0; c--) {
      districts = districts.concat(all_counties[c].district);
    }

    console.log(districts);

    /* markup list of districts */
    people[pp].dists = document.createElement('div');
    
    //make spans for the district label and add them to the list of districts
      for (var p = 0; p < districts.length; p++) {
       
        if (D.indexOf(districts[p])){
          D.push(districts[p]);
        }

        dist = document.createElement('span');
        var classes = 'js_district fsr-search__district -' + districts[p].toLowerCase();
        dist.setAttribute('class', classes);
        dist.innerHTML = districts[p];
        people[pp].dists.appendChild(dist);
      }
      people[pp].dists = people[pp].dists.innerHTML;

      //Our card in memory card
      var new_card = card_template.cloneNode(true);
      districts = '-'+districts.join(' -');
      new_card.setAttribute('data-districts', districts.toLowerCase());
    /* 
      This is for some dev ergonomics
      just make your selector up there, and add the content you want in that node
      or for attributes add an array instead of content, the array goes [attribute, name of person selector]
     */
      var content = {
        '.js_kicker' : 'dists',
        '.js_link' : ['href','url'],
        //re-using this is on purpose
        ' .js_link' : 'title',
        '.js_primary' : "email", 
        '.js_secondary' : "phone", 
        '.js_position' : 'position',
        '.js_avatar' : ['src','avatar'],
      };
    
    //FSR Agent Cards.
      //Builds the FSR Agent Cards
      for (var prop in content){
        var value = content[prop];

          if (Array.isArray(value)) {

              if(people[pp][value[1]] !== undefined){
                var att = value[0];
                var val = people[pp][value[1]];
                new_card.querySelector(prop).setAttribute(att,val);

              }

          } else {
        
              if(people[pp][value]){
                new_card.querySelector(prop).innerHTML = people[pp][value];
          
              }else{

                new_card.querySelector(prop).remove();

              }//else end

          }//if end
      
      }//for var prop in content end

    cards.appendChild(new_card);  
}

/*
  /////////////
  MAKING PEOPLE end
  \\\\\\\\\\\\\
*/


//adds cards to the dom in beautiful simple swoop
parent.innerHTML = parent.innerHTML + cards.innerHTML;


//Change Link. 
  //Adds Event Listener to go back to the input
  var fsr_reset_buttons = widget.getElementsByClassName('js-fsr_reset_button');
  for (var r = 0; r < fsr_reset_buttons.length; r++) {

      fsr_reset_button(fsr_reset_buttons[r]);
  
  }


//Search Form. 
  //Gets input and sends it off to the style_replace funciton
  var fsr_search_button = widget.getElementsByClassName('js_fsr-search__button')[0];
  var fsr_search_form = widget.getElementsByClassName('js_fsr-search__form')[0];
  fsr_search_form.id = 'js_fsr-search__form--' + i;

  //Adds an id to the parent, scoping this css to just this widget.
  widget_id = 'js_fsr_search--' + i;
  widget.setAttribute('id',widget_id);
  //get the css
  var search_css = widget.getElementsByClassName('js_fsr-search__css')[0];
  var style_id = 'js_fsr-search__css--' + i;
  search_css.setAttribute('id',style_id);
  search_css = document.getElementById(style_id);
  
  style_replace(search_css , 'data-parent', widget_id);
  
  //switch button type to prevent submitting
  fsr_search_form = document.getElementById('js_fsr-search__form--' + i);
  
//Awesome Plete
    var fsrSearchInput = widget.getElementsByClassName('js_fsr-search__input')[0];
    
    var fsrSearchAwesomplete = new Awesomplete(fsrSearchInput, {
      minChars: 2,
      autoFirst: true,
      list: D,
    });

    fsr_search_form_submit(fsr_search_form);

 /* fsr_search_form.addEventListener('submit', function(event){
    event.preventDefault();
    //get the input
     var fsr_input = this.getElementsByClassName('js_fsr-search__input')[0];
     var v = '-'+fsr_input.value.toLowerCase();
     var search_style = this.parentNode.getElementsByTagName('style')[0];
     style_replace(search_style , 'data-replace', v);
  });*/
  
}//for fsr_search_widgets loop END
  
  
}//if fsr widget exists

}///END OF FSR WIDGET

if (document.querySelector('.fsr-search')) {

  var request = new XMLHttpRequest();
  request.open('GET', window.location.protocol + '//' + window.location.host + '/wp-content/uploads/people/people.json', true);

  request.onload = function() {
    if (request.status >= 200 && request.status < 400) {
      // Success!

      var data = JSON.parse(request.responseText);
      build_fsr_cards(data);
      //console.log(data);

    } else {
      console.log('Nope sorry, couldnt get the people.json');
    }
  };

  request.onerror = function() {
    // There was a connection error of some sort
  };

  request.send();

}


//meetings search
if(document.getElementById('js-meeting-filter__form')){

  var meeting_filter_form = document.getElementById('js-meeting-filter__form');
  var meeting_filter = document.getElementById('meeting-filter');
  
  meeting_filter_form.addEventListener("submit", function(){
    
    //prevent the form from firing off
    event.preventDefault();
      console.log(meeting_filter.value);
      window.location.href = meeting_filter.value;
    
  });

}