class ContractListModel {

    constructor() {

        this.data = [];
        this._status = "";
        this.errors = ErrorValidations.newInstance();
    }

    create(status = 'pending') {

        this._status = status;
        AjaxRequest.get("contract", "list",status)
            .then(response=> {

                this.data = response.data;
                this.data.forEach((i) => {
                    i.created_at = moment(response.data.created_at).format('L');
                    //i.period_start = moment(response.data.period_start).format('L');
                    //i.period_end = moment(response.data.period_end).format('L');
                });
            });
        
    }

    cancel(contractId) {
        var that = this;
        bbox.confirm({
            title: "Contract cancel confirmation",
            message: "Do you want to cancel the contract?",
            callback: function(result) {
                if(result) {
                    AjaxRequest.post("contract","cancel",{id : contractId})
                        .then(r => {

                            if(r.data.isOk) {

                                var item = _.find(that.data,function(item) {
                                        return item.id == contractId;
                                });

                                var index = that.data.indexOf(item);
                                that.data.splice(index,1);

                            }
                        })
                        .catch(e => {
                            this.errors.register(e.response.data);
                        });
                }
            }
        });


    }

    createBill(contractId) {
        var item = _.find(this.data,function(item) {
            return item.id == contractId;
        });
        AjaxRequest.redirect("bill","create",item.contract_no);
    }
}

class ContractRenewModel {

    constructor() {
        this.data = {
            tenant: {},
            villa: {}
        };
        this.errors = ErrorValidations.newInstance();
    }
    create(id = 0,callback) {

        AjaxRequest.get('contract','renew',id)
            .then(r => {
                this.data = r.data;
                this.data.period_start = moment(this.data.period_start).format('l');
                this.data.period_end = moment(this.data.period_end).format('l');
                callback();
            })
            .catch(e => {
                console.log(e.response);
                if(e.response.status = 422) {
                    this.errors.register(e.response.data);
                    console.log(this.errors);
                }
        });
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


    save(cbSuccess) {
        var data = {
            id: this.data.id,
            period_start: this.data.period_start,
            period_end: this.data.period_end,
            amount: this.data.amount
        };

        AjaxRequest.post('contract','update',data)
            .then(r => {
                AjaxRequest.redirect('bill','create',r.data.data.id);
            })
            .catch(e => {
                if(e.response.status = 422) {
                    this.errors.register(e.response.data);
                    console.log(this.errors);
                }
            });
    }
}

export default {
    newInstance() {
        return new ContractListModel();
    },
    newInstanceRenewal() {
        return new ContractRenewModel();
    }
}