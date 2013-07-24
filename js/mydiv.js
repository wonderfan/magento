define("my/mydiv",["dojo/_base/declare",
           "dijit/_WidgetBase",
           "dijit/_TemplatedMixin",
           "dojo/text!./templates/mydiv.html"],function(declare, _WidgetBase, _TemplatedMixin, template){
	
	 return declare([_WidgetBase, _TemplatedMixin], {
         templateString: template,
         buildRendering: function(){
             this.inherited(arguments);
            this.name.innerHTML="good idea";
        }
     });
	
});

