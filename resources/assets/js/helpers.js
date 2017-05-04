
class ErrorValidations {

    constructor() {
        var that = this;
        this.errors = {};

        this.exceptions = {
            errors:[],
            add: function(name,description) {
                that.errorExceptions
                    .errors.push(
                        {
                            name:name,
                            description:description}
                        );
            }
        };
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
        var img = window.imagePath;
        window.location.href = url;
        
        return this;
    }

    redirect(controller,action,data) {

        var baseUrl = window.Laravel.baseUrl;

        var url = baseUrl + "/" + controller + "/" + (action !== null ? action : "") + (data !== null ? "/" + data : "");
        console.log(url);
        window.location.href = url;

    }

    postMultiForm(controller,action,formData) {
       return $.ajax({
                url         : '/api/'+controller+'/'+action,
                type        : 'POST',
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
