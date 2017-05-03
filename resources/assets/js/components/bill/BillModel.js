class BillModel {
        
    constructor() {
        this.payments = [];
        this.contract_id = 0;
        this._preserveInstance = {};
        this.cloneOfInstance = {};
    }

    bind(model) {
        this.contract_id = model.contract_id;
        this._preserveInstance = model.instance;
        this._preserveInstance.effectivity_date = moment(model.instance.effectivity_date).format('l');
        this._preserveInstance.period_start = moment(model.instance.period_start).format('l');
        this._preserveInstance.period_end = moment(model.instance.period_end).format('l');
    }

    createInstance() {
        this.cloneOfInstance = objectClone(this._preserveInstance);
    }

    insert(fn) {
        //check first if the instance change its type
        fn(this.cloneOfInstance);
        this.payments.push(this.cloneOfInstance);
        this.reindexing();
    }

    reindexing() {
        //create index
        for(var i = 0; i < this.payments.length; i++) {
            this.payments[i].id = i;
        }
    }

    removePayment(id) {
        this.payments.splice(id,1);
        this.reindexing();
    }

    totalAmount() {
        var sum = 0;
        for(var i=0;i < this.payments.length; i++) {
            sum +=  parseInt(this.payments[i].amount);
        }
        return sum;
    }

    saveChanges() {
        var data = {
            contract_id: this.contract_id,
            payments: this.payments};

        AjaxRequest.post('bill','store',data)
            .then(r => {
                //success saving
            })
            .catch(e => this.errors = e.data);
    }



    
}


export default {
    createInstance() {
        return new BillModel();
    }
}