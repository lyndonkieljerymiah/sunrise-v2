
class BillModel {

    constructor() {
        this.data = {
            payments: []
        };
        this.contract = {
            tenant: {},
            villa: {}
        };

        this.lookups = {};
        this.cloneOfInstance = {};
        this.errors = new window.ErrorValidations.newInstance();
    }

    create(contractId) {

        let that = this;

        AjaxRequest.get('bill', 'create', contractId)
            .then(r => {

                this.data = r.data.bill;
                this.contract = r.data.contract;
                this.lookups = r.data.lookups;

                this.data.instance.effectivity_date = moment(r.data.bill.instance.effectivity_date).format('L');
                this.data.instance.period_start = moment(r.data.bill.instance.period_start).format('L');
                this.data.instance.period_end = moment(r.data.bill.instance.period_end).format('L');

                this.createInstance();
            })
            .catch(e => {
                this.errors.register(e.data)
            });
    }

    show(billNo) {

        AjaxRequest.get('bill','show',billNo).then(r => {
            this.data = r.data.bill;
            this.contract = r.data.contract;
        });

    }

    edit(billNo) {

    }


    changePaymentType() {
        if(this.cloneOfInstance.payment_type == "cash") {
            this.cloneOfInstance.payment_no = "Cash";
            this.cloneOfInstance.bank = "Cash";
        }
        else {
            this.cloneOfInstance.payment_no = "";
            this.cloneOfInstance.bank = "";
        }
    }

    isPaymentCash() {
        return this.cloneOfInstance.payment_type === "cash" ? true : false;
    }

    createInstance() {
        this.cloneOfInstance = objectClone(this.data.instance);
    }



    insert() {

        //check first if the instance change its type
        this.lookups.payment_mode.forEach(item => {
            if(item.code === this.cloneOfInstance.payment_mode) {
                this.cloneOfInstance.full_payment_mode = item.name;
            }
        });

        this.lookups.payment_term.forEach(item =>
        {
            if(item.code === this.cloneOfInstance.payment_type)
            {
                this.cloneOfInstance.full_payment_type = item.name;
            }
        });

        this.data.payments.push(this.cloneOfInstance);
        this.reindexing();
    }

    reindexing() {
        //create index
        for(var i = 0; i < this.data.payments.length; i++) {
            this.data.payments[i].id = i;
        }
    }

    removePayment(id) {
        this.data.payments.splice(id,1);
        this.reindexing();
    }

    totalAmount() {
        var sum = 0;
        for(var i=0;i < this.data.payments.length; i++) {
            sum +=  parseInt(this.data.payments[i].amount);
        }
        return sum;
    }

    saveChanges(callback) {

        AjaxRequest.post('bill','store',this.data)
            .then(r => {
                AjaxRequest.redirect('bill','show',r.data.data.billNo);
                callback('success');
            })
            .catch(e => {
                this.errors.register(e.response.data);
                toastr.error(this.errors.get('payments'));
                callback('error')
            });
    }

    changeDate(name,d) {

        this.cloneOfInstance[name] = d;

    }
}


class BillReadableModel {

    constructor() {

        this.data = {
            payments : []
        }

        this.contract = {

        }
    }

    create(id) {
        AjaxRequest.get('bill','show',id)
            .then(r => {

            })
            .catch(e => {

            })
    }
}

export default {
    createInstance() {
        return new BillModel();
    },
    createReadbleInstance() {
        return new BillReadableModel()
    }
}

