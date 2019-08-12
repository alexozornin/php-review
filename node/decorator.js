'use strict'

const DataProvider = require('./integration.js');

/**
 * Converts an object to JSON including hidden properties
 * @param {Object} obj 
 */
function obj2json(obj) {
    let res = {};
    let props = Object.getOwnPropertyNames(obj);
    for (let i = 0; i < props.length; i++) {
        res[props[i]] = obj[props[i]];
    }
    return JSON.stringify(res);
}

class DecoratorManager extends DataProvider {
    /**
     * Creates an instance of DecoratorManager
     * @param {String} host 
     * @param {String} user 
     * @param {String} password 
     * @param {CacheItemPoolInterface} cache 
     */
    constructor(host, user, password, cache) {
        super(host, user, password);
        this.cache = cache;
    }

    /**
     * Adds a logger
     * @param {LoggerInterface} logger 
     */
    setLogger(logger) {
        this.logger = logger;
    }

    /**
     * Gets a response from remote host
     * @param {Object} input 
     */
    getResponse(input) {
        try {
            let cacheKey = JSON.stringify(input);
            let cacheItem = this.cache.getItem(cacheKey);
            if (cacheItem.isHit()) {
                return cacheItem.get();
            }

            let result = this.get(input);

            let now = new Date();
            cacheItem.set(result).expiresAt(now.setDate(now.getDate() + 1));

            return result;
        }
        catch (err) {
            let encoded_exception = obj2json(err);
            if (this.logger) {
                this.logger.critical(encoded_exception);
            }
            else {
                console.log(encoded_exception);
            }
        }

        return {};
    }
}

module.exports = DecoratorManager;
