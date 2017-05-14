export class VillaListViewModel {

    constructor() {
        this.data = {
            list: [],
            status: []
        };
    }


    create() {
        AjaxRequest.get('villa','list')
            .then(response => {
                this.data.list = response.data.data;
                this.data.status = response.data.counts;
        });
    }

    redirectToRegister(id = null) {

        AjaxRequest.redirect("villa","register",id);

    }
}



export class VillaEntryViewModel {

    constructor() {
        this.data = {
            villa: {
                villa_galleries: []
            },
            villa_newImages: []
        };
        this.lookups = {};
        this.errors = new ErrorValidations.newInstance();
    }

    create(action) {
        AjaxRequest.get('villa',action)
            .then(response => {
                this.data.villa = response.data.data;
                this.lookups = response.data.lookups;
            });
    }

    insert(file) {
        this.data.villa_newImages.push(file);
    }

    redirect() {
        AjaxRequest.redirect('villa');
    }

    save(action) {

        var formData = new FormData();

        Object.keys(this.data.villa).forEach(key => {
            if(key !== 'villa_galleries') {
                formData.append(key,this.data.villa[key]);
            }
        });
        let villaGalleries = this.data.villa.villa_galleries || [];
        if(villaGalleries.length > 0 ) {
            for(var i = 0; i < villaGalleries.length; i++) {
                if(villaGalleries[i].delete_mark == true) {
                    formData.append('villaGalleriesDeleteMark[]',villaGalleries[i].id);
                }
            }
        }

        //check galleries
        if(this.data.villa_newImages.length > 0) {
            for(var i=0; i < this.data.villa_newImages.length; i++) {
                formData.append('galleries[]', this.data.villa_newImages[i]);
            }
        }

        AjaxRequest
            .postMultiForm('villa',action,formData)
            .done(response => {
                this.redirect();
            })
            .fail(response => {
                if(response.status === 422) {
                    this.errors.register(response.responseJSON);
                }
            });
    }
}