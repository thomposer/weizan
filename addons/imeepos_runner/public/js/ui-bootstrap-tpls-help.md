#angular.module('myApp',['ui.bootstrap'])

#Accordion

	uib-accordion: close-others template-url
	
	uib-accordion-group: heading is-disabled is-open panel-class template-url
	
	uib-accordion-heading

<uib-accordion close-others="true">
	<uib-accordion-group heading="测试" is-disabled="false" is-open="false" panel-class="panel-info">
	
	</uib-accordion-group>
</uib-accordion>

#Alert
	uib-alert: close dismiss-on-timeout template-url type 

#Buttons 
	uib-btn-checkbox: btn-checkbox-fals btn-checkbox-true ng-model
	uib-btn-radio: ng-model uib-btn-radio uib-uncheckable uncheckable
	Additional: activeClass toggleEvent
	
#Carousel 
	uib-carousel: interval no-pause no-transition no-wrap template-url
	uib-slide: active actual index template-url
	
#Collapse 
	uib-collapse: uib-collapse
	
#Dateparser
	uib-datepicker-popup
	
#Datepicker 
	uib-datepicker: custom-class (date, mode) date-disabled (date, mode) datepicker-mode
	
#Dropdown 
	uib-dropdown
	
#Modal 
	$uibModal.open
	$uibModalInstance.close
	
#Pager 
	uib-pager
#Pagination
	uib-pagination
#Popover 
	
#Position 

#Progressbar 

#Rating 

#Tabs 

#Timepicker 

#Tooltip 

#Typeahead 

