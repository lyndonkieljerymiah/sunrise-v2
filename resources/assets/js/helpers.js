
class ErrorValidations {

    constructor() {
        this.errors = {}
    }

    get(field) {

        if(this.errors[field]) {
            return this.errors[field][0];
        }
        return "";
    }

    register(errors) {
        this.errors = errors;
    }

    clear(field) {

        if(this.errors[field]) {
            delete this.errors[field][0];
        }
    }
}

class AxiosRequest {
    
    post(controller,action,data) {

        return axios.post('/api/'+controller+'/'+action,data);
            
    }

    get(controller,action) {
        var qs = "";

        if(arguments.length >= 3) {
            for(var i=2;i < arguments.length; i++) {
                qs += arguments[i] + '/';
            }
        }
        
        qs = qs.substring(0,qs.length-1);

        var url = '/api/'+controller+'/'+ action + (qs!=="" ? "/" + qs : qs);
        
        return axios.get(url);

    }

    route(url) {
        
        window.location.href = url;
        
        return this;
    }

    postMultiForm(controller,action,formData) {
       return $.ajax({
                url         : '/api/'+controller+'/'+action,
                type: 'POST',
                data        : formData,
                headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken},
                processData : false,
                contentType : false,
        });
    }

}

class MomentDateFormat {

    format(carbonDate) {
        moment(carbonDate).format('dd/MM/yyyy');
    }
}


window.ErrorValidations = (function() {

    return {
        newInstance: function() { return new ErrorValidations();}
    }
}());

window.AjaxRequest = new AxiosRequest();

window.objectClone = function(objInstance) {
    return JSON.parse(JSON.stringify(objInstance));
}
