const postData=async(url="",data={})=>{NProgress.start();const response=await fetch(url,{method:"POST",mode:"cors",cache:"no-cache",credentials:"same-origin",headers:{"Content-Type":"application/json","X-CSRF-Token":$('meta[name="csrf-token"]').attr("content"),yut:"098f6bcd4621d373cade4e832627b4f6"},redirect:"follow",referrerPolicy:"no-referrer",body:JSON.stringify(data)});NProgress.done();return response.json()};