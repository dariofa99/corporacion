class Pusher{

    constructor(socket_url='https://consultoriovirtual.udenar.edu.co:3000',key='edKXuiy2wUmX9_K64OMcQQ'){
        //var socket = io('http://localhost:3000', {secure: true});
        this.socket = io(socket_url, {secure: true});
        this.key = key;
       
    }

   async on(channel,fn){       
        
    await this.socket.on(this.key+channel, function(data){
            fn(data)    
        });
        //return this.socket
    }
    

}


















