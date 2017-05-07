class ContractListModel {

    constructor() {
        this.data = []
    }

    create(status = 'active') {
         AjaxRequest.get("contract", "list",status)
            .then(response=> {
                this.data = response.data;
            });
    }
}

export default {
    newInstance() {
        return new ContractListModel();
    }
}