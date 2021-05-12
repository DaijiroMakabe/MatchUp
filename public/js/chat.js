'use strict';
// console.log('hello');

const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

// console.log("hello");
// sendBtn.onclick = ()=>{
//   console.log("good");
// }
form.onsubmit = (e)=> {
  e.preventDefault();
}
  sendBtn. onclick = ()=>{
    // start Ajax
    let xhr = new XMLHttpRequest();// XMLオブジェクトの作成
    xhr.open("POST", "/match/insert-chat.php", true);
    xhr.onload = () =>{
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          // console.log(data);
          inputField.value = ""; // メッセージを入力した後に空欄にする
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
  }

  setInterval(()=>{
    let xhr = new XMLHttpRequest();// XMLオブジェクトの作成
    xhr.open("POST", "/match/get-chat.php", true);
    xhr.onload = () =>{
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
            let data = xhr.response;
            chatBox.innerHTML = data;
          
        }
      }
    }
        let formData = new FormData(form);
        xhr.send(formData);
      }, 500); //500ms毎に実行される

  

