
class BillCreateViewModel {

    constructor() {
        this.data = {
            bill: {
                payments: [],
                paymentSummary: {
                    total_payment: 0,
                    total_cost: 0
                }
            },
            contract : {
                tenant: {},
                villa: {}
            }
        };
        this.lookups = {};
        this.cloneOfInstance = {};
        this.errors = new window.ErrorValidations.newInstance();
    }

    create(contractId) {
        AjaxRequest.get('bill', 'create', contractId)
            .then(r => {

                this.data.bill = r.data.bill;
                this.data.bill.paymentSummary = r.data.paymentSummary;

                this.data.contract = r.data.contract;
                this.lookups = r.data.lookups;

                this.data.bill.instance.effectivity_date = moment(r.data.bill.instance.effectivity_date).format('L');
                this.data.bill.instance.period_start = moment(r.data.bill.instance.period_start).format('L');
                this.data.bill.instance.period_end = moment(r.data.bill.instance.period_end).format('L');

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

        this.cloneOfInstance = objectClone(this.data.bill.instance);
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

        this.data.bill.payments.push(this.cloneOfInstance);
        this.reindexing();
    }

    reindexing() {
        //create index
        for(var i = 0; i < this.data.bill.payments.length; i++) {
            this.data.bill.payments[i].id = i;
        }
    }

    removePayment(id) {
        this.data.bill.payments.splice(id,1);
        this.reindexing();
    }

    totalAmount() {
        var sum = 0;
        for(var i=0;i < this.data.bill.payments.length; i++) {
            sum +=  parseInt(this.data.bill.payments[i].amount);
        }
        console.log(sum);
        this.data.bill.paymentSummary.total_payment = sum;
    }

    saveChanges(callback) {

        AjaxRequest.post('bill','store',this.data.bill)
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

class BillUpdateViewModel {
    constructor() {
        this.billNo = "";
        this.currentTabIndex = 'pending';
        this.loading = {search: false,save: false};
        this.data = {
            contract: { tenant:{},villa:{}},
            bill:{
                payments:[],
                paymentSummary: {}
            }
        };
        this.lookups = [];
        this.errors = new ErrorValidations.newInstance();
    }
    create() {
        this.loading.search = true;
        AjaxRequest.get('bill','edit',this.billNo)
            .then(res => {
                this.data.bill = res.data.bill;
                this.data.bill.paymentSummary = res.data.paymentSummary;
                this.data.contract = res.data.contract;
                this.lookups = res.data.lookups;
                this.billNo = "";
                this.loading.search = false;
            })
            .catch(err => {
                this.loading.search  = false;
            });
    }
    save() {
        this.loading.save = true;
        AjaxRequest.post('bill','update',this.data)
            .then(res => {
                toastr.success(res.data.message);
                this.loading.save = false;

            })
            .catch(err => {

                this.loading.save = false;

            });
    }

    getPayment(status) {
        this.data.bill.payments = [];
        AjaxRequest.get('bill','payment',this.data.bill.id,status)
            .then(res=> {
                this.data.bill.payments = res.data.bill.payments;

            })
    }

    removePayment(id) {

        let p = _.find(this.bill.payments, (p) => { return p.id == id});
        let indexOf = this.bills.payments.indexOf(p);
        this.bills.payments.splice(indexOf,1);
    }

    loadingIs(name) {
        return this.loading[name];
    }
}

export default {
    createInstance() {
        return new BillCreateViewModel();
    },
    createBillViewModelInstance() {
        return new BillUpdateViewModel()
    }
}

