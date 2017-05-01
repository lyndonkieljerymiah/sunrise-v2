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

    insert() {
        this.payments.push(this.cloneOfInstance);
    }
}


export default {
    createInstance() {
        return new BillModel();
    }
}