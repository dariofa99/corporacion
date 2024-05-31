export class HttpService {
    baseUrl 
    protocol = window.location.protocol; // 'http:' o 'https:'
    hostname = window.location.hostname; // 'www.ejemplo.com'
    
    constructor() {
        this.baseUrl = this.protocol + '//' + this.hostname;
    }
    
    async get(url, request,callback) {
        const response = await fetch(this.baseUrl + "/"+url+"?" + new URLSearchParams(request), {
            method: 'GET',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $("#token").attr("content"),
            }

        });     
        if (!response.ok) {
            const message = `An error has occured: ${response.status}`;
            throw new Error(message);
        }
        const topics = await response.json();
        return callback(topics)
    }

    async post(url,request,callback) {
       var response = await fetch(this.baseUrl + "/"+url, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $("#token").attr('content'),
            },
            body: JSON.stringify(request)
        });
         if (!response.ok) {
            const message = `An error has occured: ${response.status}`;
            console.log(response);
            throw new Error(message);
        }
        const topics = await response.json();
        return callback(topics)
        /* const topics = await response.json();
        return topics; */
    }
}