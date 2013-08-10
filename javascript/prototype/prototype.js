var myClass = Class.create({
    initialize:function(){
        this.values = {};
        this.name ="china";
        this.get = function(key){
            return this.values[key];
        }
    },
    echo: function(message){ console.log(message);}    
    
});

var wonderfan = window.wonderfan || (window.wonderfan = {});
