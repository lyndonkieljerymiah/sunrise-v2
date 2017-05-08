class ContractListModel {

    constructor() {
        this.data = []
        this._status = "";
    }

    create(status = 'active') {
        this._status = status;
        AjaxRequest.get("contract", "list",status)
            .then(response=> {
                this.data = response.data;
                this.errors = ErrorValidations.newInstance();
            });
        
    }

    cancel(contractId) {
        
        bbox.confirm({
            title: "Contract cancel confirmation",
            message: "Do you want to cancel the contract?",
            callback(result) {
                if(result) {
                    AjaxRequest.post("contract","cancel",{id : contractId})
                        .then(r => {
                            
                            //this.data.splice(id,1);
                        })  
                        .catch(e => {
                            if(e.response.status == 422)
                                this.errors.register(e.response.data)
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
    
}

export default {
    newInstance() {
        return new ContractListModel();
    }
}