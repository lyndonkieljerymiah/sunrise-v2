
class ContractRegisterModel {

    constructor() {

        this.lookups = [];

        this.errors = ErrorValidations.newInstance();

        this.data = {
            register_tenant: {
                address_instance: {}
            }
        }


        this.selected = {};

        this.label = {
            regName: "Company",
            fullName: "Full Name",
            regDate: "Birthday",
            regNo: "Qatar Id"
        }
    }
    create() {

        var that = this;

        AjaxRequest.get('contract','create').then((r) => {
            that.data = r.data.data;
            that.lookups = r.data.lookups;

            that.data.period_start = moment(that.data.period_start).format('L');
            that.data.period_end = moment(that.data.period_end).format('L');
            that.data.register_tenant.reg_date = moment(that.data.register_tenant.reg_date).format('L');
        });
    }
    select() {
        var id = this.data.villa_id;
        var that = this;
        this.data.villa_list.forEach(function(item) {
            if(item.id == id) {
                that.selected = item;
                return true;
            }
        }, this);        
    }

    recal(cbSuccess,cbError) {

        var data = {
            villa_id: this.data.villa_id,
            period_start: this.data.period_start,
            period_end: this.data.period_end
        };

        AjaxRequest.post("contract","recal",data)
            .then((r) => {
                this.data.amount = r.data.amount;
                if(cbSuccess) cbSuccess(r.data);
            })
            .catch((e) => {
                if(cbError) cbError();
            });
    }

    onTenantTypeChange() {

        if(this.data.register_tenant.type == 'individual') {
            this.label.regName = "Company";
            this.label.fullName = "Full Name";
            this.label.regDate = "Birthday";
            this.label.regNo = "Qatar Id";
        }
        else {
            this.label.regName = "Representative";
            this.label.fullName = "Business Name";
            this.label.regDate = "Validity Date";
            this.label.regNo = "CR No";
        }
    }

    isShowBirthday() {
        return this.data.register_tenant.type == "individual" ? true : false;
    }
    changeDate(name,d) {
        var dot = name.split(".");
        if(dot.length > 1) {
            var tenant = this.data[dot[0]];
            tenant[dot[1]] = d;
        }
        else {
            this.data[name] = d;
        }

    }

    save(cbSuccess,cbError) {

        AjaxRequest.post("contract","store",this.data)
            .then((r) => {
                if(cbSuccess) cbSuccess(r.data);
                AjaxRequest.redirect("bill","create",r.data.data.id);
            })
            .catch((error) => {
                if(error.response.status == 422)
                    this.errors.register(error.response.data);
                if(cbError) cbError();
            });
    }
}

export default {
    createInstance() {
        return new ContractRegisterModel();
    }
}