'use strict'

class DataProvider {
    /**
     * Creates a new instance of DataProvider
     * @param {String} host 
     * @param {String} user 
     * @param {String} password 
     */
    constructor(host, user, password) {
        this.host = host;
        this.user = user;
        this.password = password;
    }

    /**
     * Sends a request to remote host
     * @param {Object} request 
     */
    get(request) {
        return {};
    }
}

module.exports = DataProvider;
