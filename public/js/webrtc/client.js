var mywebrtc;
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/client.js":
/*!***********************!*\
  !*** ./src/client.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "g_elementCheckboxCamera": () => (/* binding */ g_elementCheckboxCamera),
/* harmony export */   "g_elementCheckboxMicrophone": () => (/* binding */ g_elementCheckboxMicrophone),
/* harmony export */   "g_elementVideoLocal": () => (/* binding */ g_elementVideoLocal),
/* harmony export */   "g_elementAudioLocal": () => (/* binding */ g_elementAudioLocal),
/* harmony export */   "g_elementVideoRemote": () => (/* binding */ g_elementVideoRemote),
/* harmony export */   "g_elementAudioRemote": () => (/* binding */ g_elementAudioRemote),
/* harmony export */   "GlobalRTCParms": () => (/* binding */ GlobalRTCParms),
/* harmony export */   "g_elementTextareaOfferSideOfferSDP": () => (/* binding */ g_elementTextareaOfferSideOfferSDP),
/* harmony export */   "g_elementTextareaAnswerSideAnswerSDP": () => (/* binding */ g_elementTextareaAnswerSideAnswerSDP),
/* harmony export */   "setEndPoint": () => (/* binding */ setEndPoint),
/* harmony export */   "connectionType": () => (/* binding */ connectionType),
/* harmony export */   "videoStart": () => (/* binding */ videoStart),
/* harmony export */   "retry": () => (/* binding */ retry),
/* harmony export */   "RemoteHelper": () => (/* reexport safe */ _remote_js__WEBPACK_IMPORTED_MODULE_0__.RemoteHelper),
/* harmony export */   "onclickCheckbox_CameraMicrophone": () => (/* reexport safe */ _video_js__WEBPACK_IMPORTED_MODULE_3__.onclickCheckbox_CameraMicrophone),
/* harmony export */   "setAnswerSDPthenChatStarts": () => (/* reexport safe */ _webrtc_offer_js__WEBPACK_IMPORTED_MODULE_1__.setAnswerSDPthenChatStarts)
/* harmony export */ });
/* harmony import */ var _remote_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./remote.js */ "./src/remote.js");
/* harmony import */ var _webrtc_offer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./webrtc/offer.js */ "./src/webrtc/offer.js");
/* harmony import */ var _webrtc_answer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./webrtc/answer.js */ "./src/webrtc/answer.js");
/* harmony import */ var _video_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./video.js */ "./src/video.js");




console.log("Hello World!");
var g_elementCheckboxCamera = document.getElementById("checkbox_camera");
var g_elementCheckboxMicrophone = document.getElementById("checkbox_microphone");
var g_elementVideoLocal = document.getElementById("video_local");
var g_elementAudioLocal = document.getElementById("audio_local");
var g_elementVideoRemote = document.getElementById("video_remote");
var g_elementAudioRemote = document.getElementById("audio_remote");
var GlobalRTCParms = {
  g_rtcPeerConnection: null
};
var g_elementTextareaOfferSideOfferSDP = document.getElementById("textarea_offerside_offersdp");
var g_elementTextareaAnswerSideAnswerSDP = document.getElementById("textarea_answerside_answersdp");
var setEndPoint = function setEndPoint(data) {
  _remote_js__WEBPACK_IMPORTED_MODULE_0__.RemoteHelper.endpoints = data;
};
var connectionType = function connectionType(type) {
  _remote_js__WEBPACK_IMPORTED_MODULE_0__.RemoteHelper.type = type;
}; // amend isHostはhostではないとundefinedになっているからconnectionTypeに変更したい。

var videoStart = function videoStart(isHost) {
  console.log("videoStart");
  _video_js__WEBPACK_IMPORTED_MODULE_3__.mediaManeger.bCamera_new = true;
  g_elementCheckboxCamera.checked = true;
  _video_js__WEBPACK_IMPORTED_MODULE_3__.mediaManeger.bMicrophone_new = true;
  (0,_video_js__WEBPACK_IMPORTED_MODULE_3__.onclickCheckbox_CameraMicrophone)(function () {
    //hostならcreateoffersdp,guestならanswersdp作成
    console.log("isHost", isHost);
    GlobalRTCParms.g_rtcPeerConnection = null;

    if (isHost) {
      console.log("host");
      (0,_webrtc_offer_js__WEBPACK_IMPORTED_MODULE_1__.start_createOfferSDP)();
    } else {
      //console.log("guset");
      //setOfferSDPandCreateAnswerSDP();
      _remote_js__WEBPACK_IMPORTED_MODULE_0__.RemoteHelper.start();
    }
  });
};
var retry = function retry() {
  GlobalRTCParms.g_rtcPeerConnection = null;

  if (_remote_js__WEBPACK_IMPORTED_MODULE_0__.RemoteHelper.type == "offer") {
    console.log("host");
    (0,_webrtc_offer_js__WEBPACK_IMPORTED_MODULE_1__.start_createOfferSDP)();
  } else if (_remote_js__WEBPACK_IMPORTED_MODULE_0__.RemoteHelper.type = "answer") {
    //console.log("guset");
    //setOfferSDPandCreateAnswerSDP();
    _remote_js__WEBPACK_IMPORTED_MODULE_0__.RemoteHelper.start();
  }
};
_remote_js__WEBPACK_IMPORTED_MODULE_0__.RemoteHelper.prepare( // offer side
function (data) {
  (0,_webrtc_offer_js__WEBPACK_IMPORTED_MODULE_1__.setAnswerSDPthenChatStarts)(data);
}, //answer side
//setOfferSDPandCreateAnswerSDP(data)
function (data) {
  (0,_webrtc_answer_js__WEBPACK_IMPORTED_MODULE_2__.setOfferSDPandCreateAnswerSDP)(data);
});


/***/ }),

/***/ "./src/remote.js":
/*!***********************!*\
  !*** ./src/remote.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "RemoteHelper": () => (/* binding */ RemoteHelper)
/* harmony export */ });
var RemoteHelper = {
  isHost: null,
  endpoints: {},
  watingSDP: false,
  type: null,
  start: function start() {
    console.log("start polling");
    RemoteHelper.waitingSdp = true;
  },
  stop: function stop() {
    console.log("stop polling");
    RemoteHelper.waitingSdp = false;
  },
  emit: function emit(event, options) {
    // amend options.data.typeにoffer answer情報入っているが使わない?
    // offer answerの判別はcontroller側で判定
    var sdp = options.data.sdp;
    var endpoint = RemoteHelper.endpoints.update_sdp;
    $.post(endpoint, {
      sdp: sdp
    }, function (res) {});
  },
  prepare: function prepare(offerSide_callback, answerSide_callback) {
    console.log("prepare");
    setInterval(function () {
      console.log("prepare setInterval");

      if (RemoteHelper.waitingSdp == true) {
        console.log("watingSDP = true");
        var endpoint = RemoteHelper.endpoints.get_video_info;
        var callback = null;

        if (RemoteHelper.type == "offer") {
          callback = offerSide_callback;
        } else if (RemoteHelper.type == "answer") {
          callback = answerSide_callback;
        } else {
          console.log("callback empty");
          return;
        }

        $.ajax({
          type: "GET",
          url: endpoint,
          dataType: "json"
        }).done(function (data) {
          callback(data); // amend stopはsetRemoteDescriptionの後に記述した方がいいのか？
        });
      }
    }, 5000);
  }
};

/***/ }),

/***/ "./src/video.js":
/*!**********************!*\
  !*** ./src/video.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "mediaManeger": () => (/* binding */ mediaManeger),
/* harmony export */   "onclickCheckbox_CameraMicrophone": () => (/* binding */ onclickCheckbox_CameraMicrophone),
/* harmony export */   "setStreamToElement": () => (/* binding */ setStreamToElement)
/* harmony export */ });
/* harmony import */ var _client_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./client.js */ "./src/client.js");

var mediaManeger = {
  bCamera_new: false
}; // カメラとマイクのOn/Offのチェックボックスを押すと呼ばれる関数

var onclickCheckbox_CameraMicrophone = function onclickCheckbox_CameraMicrophone(callback) {
  console.log("UI Event : Camera/Microphone checkbox clicked."); // これまでの状態

  var trackCamera_old = null;
  var trackMicrophone_old = null;
  var bCamera_old = false;
  var bMicrophone_old = false;
  var stream = _client_js__WEBPACK_IMPORTED_MODULE_0__.g_elementVideoLocal.srcObject;

  if (stream) {
    trackCamera_old = stream.getVideoTracks()[0];

    if (trackCamera_old) {
      bCamera_old = true;
    }

    trackMicrophone_old = stream.getAudioTracks()[0];

    if (trackMicrophone_old) {
      bMicrophone_old = true;
    }
  } // 今後の状態
  // video startを押したら開始
  // video startを押していなくても、チェックフラグ＝trueで開始
  // チェックフラグ=falseで停止


  var bCamera_new = false;
  bCamera_new = mediaManeger.bCamera_new;

  if (_client_js__WEBPACK_IMPORTED_MODULE_0__.g_elementCheckboxCamera.checked == false) {
    bCamera_new = false;
  } else {
    bCamera_new = true;
  }

  var bMicrophone_new = false;
  bMicrophone_new = mediaManeger.bMicrophone_new;

  if (_client_js__WEBPACK_IMPORTED_MODULE_0__.g_elementCheckboxMicrophone.checked == false) {
    bMicrophone_new = false;
  } else {
    bMicrophone_new = true;
  } // 状態変化


  console.log("Camera :  %s => %s", bCamera_old, bCamera_new);
  console.log("Microphoneo : %s = %s", bMicrophone_old, bMicrophone_new);

  if (bCamera_old === bCamera_new && bMicrophone_old === bMicrophone_new) {
    // チェックボックスの状態の変化なし
    if (callback) callback();
    return;
  }

  console.log("trackCamera_old", trackCamera_old); // 古いメディアストリームのトラックの停止（トラックの停止をせず、HTML要素のstreamの解除だけではカメラは停止しない（カメラ動作LEDは点いたまま））

  if (trackCamera_old) {
    console.log("Call : trackCamera_old.stop()");
    trackCamera_old.stop();
  }

  if (trackMicrophone_old) {
    console.log("Call : trackMicrophone_old.stop()");
    trackMicrophone_old.stop();
  } // HTML要素のメディアストリームの解除


  console.log("Call : setStreamToElement( Video_Local, null )");
  setStreamToElement(_client_js__WEBPACK_IMPORTED_MODULE_0__.g_elementVideoLocal, null);

  if (!bCamera_new && !bMicrophone_new) {
    // （チェックボックスの状態の変化があり、かつ、）カメラとマイクを両方Offの場合
    return;
  } // （チェックボックスの状態の変化があり、かつ、）カメラとマイクのどちらかもしくはどちらもOnの場合
  // 自分のメディアストリームを取得する。
  // - 古くは、navigator.getUserMedia() を使用していたが、廃止された。
  //   現在は、navigator.mediaDevices.getUserMedia() が新たに用意され、これを使用する。


  console.log("Call : navigator.mediaDevices.getUserMedia( video=%s, audio=%s )", bCamera_new, bMicrophone_new);
  navigator.mediaDevices.getUserMedia({
    video: bCamera_new,
    audio: bMicrophone_new
  }).then(function (stream) {
    // HTML要素へのメディアストリームの設定
    console.log("Call : setStreamToElement( Video_Local, stream )");
    setStreamToElement(_client_js__WEBPACK_IMPORTED_MODULE_0__.g_elementVideoLocal, stream);
    console.log("setStreamToElement complete");
    if (callback) callback();
  })["catch"](function (error) {
    // メディアストリームの取得に失敗⇒古いメディアストリームのまま。チェックボックスの状態を戻す。
    console.error("Error : ", error);
    alert("Could not start Camera.");
    _client_js__WEBPACK_IMPORTED_MODULE_0__.g_elementCheckboxCamera.checked = false;
    _client_js__WEBPACK_IMPORTED_MODULE_0__.g_elementCheckboxMicrophone.checked = false;
    return;
  });
}; // HTML要素へのメディアストリームの設定（もしくは解除。および開始）
// HTML要素は、「ローカルもしくはリモート」の「videoもしくはaudio」。
// メディアストリームは、ローカルメディアストリームもしくはリモートメディアストリーム、もしくはnull。
// メディアストリームには、Videoトラック、Audioトラックの両方もしくは片方のみが含まれる。
// メディアストリームに含まれるトラックの種別、設定するHTML要素種別は、呼び出し側で対処する。

function setStreamToElement(elementMedia, stream) {
  console.log("setStreamToElement"); // メディアストリームを、メディア用のHTML要素のsrcObjに設定する。
  // - 古くは、elementVideo.src = URL.createObjectURL( stream ); のように書いていたが、URL.createObjectURL()は、廃止された。
  //   現在は、elementVideo.srcObject = stream; のように書く。

  elementMedia.srcObject = stream;

  if (!stream) {
    // メディアストリームの設定解除の場合は、ここで処理終了
    return;
  } // 音量


  if ("VIDEO" === elementMedia.tagName) {
    // VIDEO：ボリュームゼロ、ミュート
    elementMedia.volume = 0.0;
    elementMedia.muted = true;
  } else if ("AUDIO" === elementMedia.tagName) {
    // AUDIO：ボリュームあり、ミュートでない
    elementMedia.volume = 1.0;
    elementMedia.muted = false;
  } else {
    console.error("Unexpected : Unknown ElementTagName : ", elementMedia.tagName);
  }
}

/***/ }),

/***/ "./src/webrtc/answer.js":
/*!******************************!*\
  !*** ./src/webrtc/answer.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "setOfferSDPandCreateAnswerSDP": () => (/* binding */ setOfferSDPandCreateAnswerSDP)
/* harmony export */ });
/* harmony import */ var _client_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../client.js */ "./src/client.js");
/* harmony import */ var _webrtc_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./webrtc.js */ "./src/webrtc/webrtc.js");

 // prepareに渡すcallback関数に変更

var setOfferSDPandCreateAnswerSDP = function setOfferSDPandCreateAnswerSDP(data) {
  // amend UI Eventではない
  console.log("UI Event : 'Set OfferSDP and Create AnswerSDP.' button clicked.");

  if (_client_js__WEBPACK_IMPORTED_MODULE_0__.GlobalRTCParms.g_rtcPeerConnection) {
    // 既にコネクションオブジェクトあり
    alert("Connection object already exists.");
    return;
  } // const callback = (data) =>{
  // amend もっと上手い判定の仕方はないのか


  if (!data.host_join.offer_sdp) {
    // OfferSDPが空
    console.log("OfferSDP is empty. Please enter the OfferSDP.");
    return;
  }

  var strOfferSDP = data.host_join.offer_sdp + "\r\n"; // RTCPeerConnectionオブジェクトの作成

  console.log("Call : createPeerConnection()");
  var rtcPeerConnection = (0,_webrtc_js__WEBPACK_IMPORTED_MODULE_1__.createPeerConnection)(_client_js__WEBPACK_IMPORTED_MODULE_0__.g_elementVideoLocal.srcObject);
  _client_js__WEBPACK_IMPORTED_MODULE_0__.GlobalRTCParms.g_rtcPeerConnection = rtcPeerConnection; // グローバル変数に設定
  // OfferSDPの設定とAnswerSDPの作成

  var sessionDescription = new RTCSessionDescription({
    type: "offer",
    sdp: strOfferSDP
  });
  console.log("Call : setOfferSDP_and_createAnswerSDP()");
  setOfferSDP_and_createAnswerSDP(rtcPeerConnection, sessionDescription); // }
  // const endpoint = RemoteHelper.endpoints.get_video_info;
  // $.ajax({
  //     type:"GET",
  //     url:endpoint,
  //     dataType: "json"
  // }).done((data)=>{
  //     callback(data.host_join);
  // })
}; // OfferSDPの設定とAnswerSDPの作成
// amend 関数名何とかならない？上とほぼかぶっている

function setOfferSDP_and_createAnswerSDP(rtcPeerConnection, sessionDescription) {
  console.log("Call : rtcPeerConnection.setRemoteDescription()");
  console.log("sessionDescription", sessionDescription);
  rtcPeerConnection.setRemoteDescription(sessionDescription).then(function () {
    // AnswerSDPの作成
    console.log("Call : rtcPeerConnection.createAnswer()");
    return rtcPeerConnection.createAnswer();
  }).then(function (sessionDescription) {
    // 作成されたAnswerSDPををLocalDescriptionに設定
    console.log("Call : rtcPeerConnection.setLocalDescription()");
    return rtcPeerConnection.setLocalDescription(sessionDescription);
  }).then(function () {
    // Vanilla ICEの場合は、まだSDPを相手に送らない
    // Trickle ICEの場合は、初期SDPを相手に送る
    _client_js__WEBPACK_IMPORTED_MODULE_0__.RemoteHelper.stop();
  })["catch"](function (error) {
    console.error("Error : ", error);
  });
}

/***/ }),

/***/ "./src/webrtc/offer.js":
/*!*****************************!*\
  !*** ./src/webrtc/offer.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "start_createOfferSDP": () => (/* binding */ start_createOfferSDP),
/* harmony export */   "setAnswerSDPthenChatStarts": () => (/* binding */ setAnswerSDPthenChatStarts)
/* harmony export */ });
/* harmony import */ var _client_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../client.js */ "./src/client.js");
/* harmony import */ var _remote_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../remote.js */ "./src/remote.js");
/* harmony import */ var _webrtc_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./webrtc.js */ "./src/webrtc/webrtc.js");


 // 「Create OfferSDP.」ボタンを押すと呼ばれる関数

var start_createOfferSDP = function start_createOfferSDP() {
  //console.log( "UI Event : 'Create Offer SDP.' button clicked." );
  console.log("Create Offer SDP"); //let g_rtcPeerConnection = null;

  if (_client_js__WEBPACK_IMPORTED_MODULE_0__.GlobalRTCParms.g_rtcPeerConnection) {
    // 既にコネクションオブジェクトあり
    alert("Connection object already exists.");
    return;
  } // RTCPeerConnectionオブジェクトの作成


  console.log("Call : createPeerConnection()");
  var rtcPeerConnection = (0,_webrtc_js__WEBPACK_IMPORTED_MODULE_2__.createPeerConnection)(_client_js__WEBPACK_IMPORTED_MODULE_0__.g_elementVideoLocal.srcObject); //g_rtcPeerConnection = rtcPeerConnection;    // グローバル変数に設定

  _client_js__WEBPACK_IMPORTED_MODULE_0__.GlobalRTCParms.g_rtcPeerConnection = rtcPeerConnection; // OfferSDPの作成

  createOfferSDP(rtcPeerConnection);
}; // OfferSDPの作成

var createOfferSDP = function createOfferSDP(rtcPeerConnection) {
  // OfferSDPの作成
  console.log("Call : rtcPeerConnection.createOffer()");
  rtcPeerConnection.createOffer().then(function (sessionDescription) {
    // 作成されたOfferSDPををLocalDescriptionに設定
    console.log("Call : rtcPeerConnection.setLocalDescription()");
    return rtcPeerConnection.setLocalDescription(sessionDescription);
  }).then(function () {// Vanilla ICEの場合は、まだSDPを相手に送らない
    // Trickle ICEの場合は、初期SDPを相手に送る
  })["catch"](function (error) {
    console.error("Error : ", error);
  });
}; // amend pollingでanswersideのsdpが発行された情報を取得する必要あり。
// 「Set AnswerSDP. Then the chat starts.」ボタンを押すと呼ばれる関数


function setAnswerSDPthenChatStarts(data) {
  // amend buttonではない
  console.log("UI Event : 'Set AnswerSDP. Then the chat starts.' button clicked.");

  if (!_client_js__WEBPACK_IMPORTED_MODULE_0__.GlobalRTCParms.g_rtcPeerConnection) {
    // コネクションオブジェクトがない
    alert("Connection object does not exist.");
    return;
  } // const callback = (data) =>{
  // AnswerSDPを、テキストエリアから取得


  if (!data.guest_join.answer_sdp) {
    // AnswerSDPが空
    console.log("AnswerSDP is empty. Please enter the AnswerSDP.");
    return;
  }

  if (data.guest_join.updated_at < data.host_join.updated_at) {
    console.log("Answer sdp isn't updated");
    return;
  }

  var OfferSideAnswerSDP = data.guest_join.answer_sdp + "\r\n";
  console.log("OfferSideAnswerSDP", OfferSideAnswerSDP); // AnswerSDPの設定

  var sessionDescription = new RTCSessionDescription({
    type: "answer",
    sdp: OfferSideAnswerSDP
  }); //console.log("OfferSideAnswerSDP",OfferSideAnswerSDP);

  console.log("Call : setAnswerSDP()");
  setAnswerSDP(_client_js__WEBPACK_IMPORTED_MODULE_0__.GlobalRTCParms.g_rtcPeerConnection, sessionDescription); // }
  //   const endpoint = RemoteHelper.endpoints.get_video_info;
  //   $.ajax({
  //       type:"GET",
  //       url:endpoint,
  //       dataType: "json"
  //   }).done((data)=>{
  //       console.log("answer data",data);
  //       callback(data);
  //   });
} // AnswerSDPの設定

function setAnswerSDP(rtcPeerConnection, sessionDescription) {
  console.log("Call : rtcPeerConnection.setRemoteDescription()");
  rtcPeerConnection.setRemoteDescription(sessionDescription).then(function () {
    _remote_js__WEBPACK_IMPORTED_MODULE_1__.RemoteHelper.stop();
  })["catch"](function (error) {
    console.error("Error : ", error);
  });
}

/***/ }),

/***/ "./src/webrtc/webrtc.js":
/*!******************************!*\
  !*** ./src/webrtc/webrtc.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "createPeerConnection": () => (/* binding */ createPeerConnection),
/* harmony export */   "setupRTCPeerConnectionEventHandler": () => (/* binding */ setupRTCPeerConnectionEventHandler)
/* harmony export */ });
/* harmony import */ var _remote_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../remote.js */ "./src/remote.js");
/* harmony import */ var _video_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../video.js */ "./src/video.js");
/* harmony import */ var _client_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../client.js */ "./src/client.js");


 // RTCPeerConnectionオブジェクトの作成

var createPeerConnection = function createPeerConnection(stream) {
  console.log("createPeerConnection"); // RTCPeerConnectionオブジェクトの生成

  var config = {
    "iceServers": [{
      "urls": "stun:stun.l.google.com:19302"
    }, {
      "urls": "stun:stun1.l.google.com:19302"
    }, {
      "urls": "stun:stun2.l.google.com:19302"
    }]
  };
  var rtcPeerConnection = new RTCPeerConnection(config); // RTCPeerConnectionオブジェクトのイベントハンドラの構築

  setupRTCPeerConnectionEventHandler(rtcPeerConnection); // RTCPeerConnectionオブジェクトのストリームにローカルのメディアストリームを追加

  if (stream) {
    // - 古くは、RTCPeerConnection.addStream(stream) を使用していたが、廃止予定となった。
    //   現在は、RTCPeerConnection.addTrack(track, stream) を使用する。
    stream.getTracks().forEach(function (track) {
      rtcPeerConnection.addTrack(track, stream);
    });
  } else {
    console.log("No local stream.");
  }

  return rtcPeerConnection;
}; // RTCPeerConnectionオブジェクトのイベントハンドラの構築

var setupRTCPeerConnectionEventHandler = function setupRTCPeerConnectionEventHandler(rtcPeerConnection) {
  // Negotiation needed イベントが発生したときのイベントハンドラ
  // - このイベントは、セッションネゴシエーションを必要とする変更が発生したときに発生する。
  //   一部のセッション変更はアンサーとしてネゴシエートできないため、このネゴシエーションはオファー側として実行されなければならない。
  //   最も一般的には、negotiationneededイベントは、RTCPeerConnectionに送信トラックが追加された後に発生する。
  //   ネゴシエーションがすでに進行しているときに、ネゴシエーションを必要とする方法でセッションが変更された場合、
  //   ネゴシエーションが完了するまで、negotiationneededイベントは発生せず、ネゴシエーションがまだ必要な場合にのみ発生する。
  //   see : https://developer.mozilla.org/en-US/docs/Web/API/RTCPeerConnection/onnegotiationneeded
  rtcPeerConnection.onnegotiationneeded = function () {
    console.log("Event : Negotiation needed");
  }; // ICE candidate イベントが発生したときのイベントハンドラ
  // - これは、ローカルのICEエージェントがシグナリング・サーバを介して
  //   他のピアにメッセージを配信する必要があるときはいつでも発生する。
  //   これにより、ブラウザ自身がシグナリングに使用されている技術についての詳細を知る必要がなく、
  //   ICE エージェントがリモートピアとのネゴシエーションを実行できるようになる。
  //   see : https://developer.mozilla.org/en-US/docs/Web/API/RTCPeerConnection/onicecandidate


  rtcPeerConnection.onicecandidate = function (event) {
    console.log("Event : ICE candidate");

    if (event.candidate) {
      // ICE candidateがある
      console.log("- ICE candidate : ", event.candidate); // Vanilla ICEの場合は、何もしない
      // Trickle ICEの場合は、ICE candidateを相手に送る
    } else {
      // ICE candiateがない = ICE candidate の収集終了。
      console.log("- ICE candidate : empty");
    }
  }; // ICE candidate error イベントが発生したときのイベントハンドラ
  // - このイベントは、ICE候補の収集処理中にエラーが発生した場合に発生する。
  //   see : https://developer.mozilla.org/en-US/docs/Web/API/RTCPeerConnection/onicecandidateerror


  rtcPeerConnection.onicecandidateerror = function (event) {
    console.error("Event : ICE candidate error. error code : ", event.errorCode);
  }; // ICE gathering state change イベントが発生したときのイベントハンドラ
  // - このイベントは、ICE gathering stateが変化したときに発生する。
  //   言い換えれば、ICEエージェントがアクティブに候補者を収集しているかどうかが変化したときに発生する。
  //   see : https://developer.mozilla.org/en-US/docs/Web/API/RTCPeerConnection/onicegatheringstatechange


  rtcPeerConnection.onicegatheringstatechange = function () {
    console.log("Event : ICE gathering state change");
    console.log("- ICE gathering state : ", rtcPeerConnection.iceGatheringState);

    if ("complete" === rtcPeerConnection.iceGatheringState) {
      if ("offer" == rtcPeerConnection.localDescription.type) {
        // Vanilla ICEの場合は、ICE candidateを含んだOfferSDP/AnswerSDPを相手に送る
        // Trickle ICEの場合は、何もしない
        // Offer側のOfferSDP用のテキストエリアに貼付
        // amend 以下不要
        console.log("- Set OfferSDP in textarea"); // g_elementTextareaOfferSideOfferSDP.value = rtcPeerConnection.localDescription.sdp;
        // g_elementTextareaOfferSideOfferSDP.focus();
        // g_elementTextareaOfferSideOfferSDP.select();

        _remote_js__WEBPACK_IMPORTED_MODULE_0__.RemoteHelper.emit("signaling", {
          type: "offer",
          data: rtcPeerConnection.localDescription
        }); // ここにstart入れている理由は何だっけ??? offer側がanswer側sdpをセットする処理の開始のため

        _remote_js__WEBPACK_IMPORTED_MODULE_0__.RemoteHelper.start();
      } else if ("answer" === rtcPeerConnection.localDescription.type) {
        // Answer側のAnswerSDP用のテキストエリアに貼付
        console.log("- Set AnswerSDP in textarea"); // g_elementTextareaAnswerSideAnswerSDP.value = rtcPeerConnection.localDescription.sdp;
        // g_elementTextareaAnswerSideAnswerSDP.focus();
        // g_elementTextareaAnswerSideAnswerSDP.select();
        // amend 上のコードと重複部分消せない?

        _remote_js__WEBPACK_IMPORTED_MODULE_0__.RemoteHelper.emit("signaling", {
          type: "answer",
          data: rtcPeerConnection.localDescription
        });
      } else {
        console.error("Unexpected : Unknown localDescription.type. type = ", rtcPeerConnection.localDescription.type);
      }
    }
  }; // ICE connection state change イベントが発生したときのイベントハンドラ
  // - このイベントは、ネゴシエーションプロセス中にICE connection stateが変化するたびに発生する。 
  // - 接続が成功すると、通常、状態は「new」から始まり、「checking」を経て、「connected」、最後に「completed」と遷移します。 
  //   ただし、特定の状況下では、「connected」がスキップされ、「checking」から「completed」に直接移行する場合があります。
  //   これは、最後にチェックされた候補のみが成功した場合に発生する可能性があり、成功したネゴシエーションが完了する前に、
  //   収集信号と候補終了信号の両方が発生します。
  //   see : https://developer.mozilla.org/en-US/docs/Web/API/RTCPeerConnection/iceconnectionstatechange_event


  rtcPeerConnection.oniceconnectionstatechange = function () {
    console.log("Event : ICE connection state change");
    console.log("- ICE connection state : ", rtcPeerConnection.iceConnectionState);
    console.log("test:", rtcPeerConnection.iceConnectionState); // "disconnected" : コンポーネントがまだ接続されていることを確認するために、RTCPeerConnectionオブジェクトの少なくとも
    //                  1つのコンポーネントに対して失敗したことを確認します。これは、"failed "よりも厳しいテストではなく、
    //                  断続的に発生し、信頼性の低いネットワークや一時的な切断中に自然に解決することがあります。問題が
    //                  解決すると、接続は "接続済み "の状態に戻ることがあります。
    // "failed"       : ICE candidateは、すべての候補のペアを互いにチェックしたが、接続のすべてのコンポーネントに
    //                  互換性のあるものを見つけることができなかった。しかし、ICEエージェントがいくつかの
    //                  コンポーネントに対して互換性のある接続を見つけた可能性がある。
    // see : https://developer.mozilla.org/en-US/docs/Web/API/RTCPeerConnection/iceConnectionState

    if (rtcPeerConnection.iceConnectionState == "disconnected") {
      console.log("retry"); //console.log("RemoteHelper.isHost",RemoteHelper.isHost);
      // if(RemoteHelper.type == "offer"){
      //     // host切断時は、offerから再作成するため１からリトライ
      //     retry();
      // }
      // else if(RemoteHelper.type == "answer" ){
      //     //guest切断時は、offer再設定するための、初期化処理
      //     GlobalRTCParms.g_rtcPeerConnection = null;
      // }

      (0,_client_js__WEBPACK_IMPORTED_MODULE_2__.retry)();
    }
  }; // Signaling state change イベントが発生したときのイベントハンドラ
  // - このイベントは、ピア接続のsignalStateが変化したときに送信される。
  //   これは、setLocalDescription（）またはsetRemoteDescription（）の呼び出しが原因で発生する可能性がある。
  //   see : https://developer.mozilla.org/en-US/docs/Web/API/RTCPeerConnection/onsignalingstatechange


  rtcPeerConnection.onsignalingstatechange = function () {
    console.log("Event : Signaling state change");
    console.log("- Signaling state : ", rtcPeerConnection.signalingState);
  }; // Connection state change イベントが発生したときのイベントハンドラ
  // - このイベントは、ピア接続の状態が変化したときに送信される。
  //   see : https://developer.mozilla.org/en-US/docs/Web/API/RTCPeerConnection/onconnectionstatechange


  rtcPeerConnection.onconnectionstatechange = function () {
    console.log("Event : Connection state change");
    console.log("- Connection state : ", rtcPeerConnection.connectionState); // "disconnected" : 接続のためのICEトランスポートの少なくとも1つが「disconnected」状態であり、
    //                  他のトランスポートのどれも「failed」、「connecting」、「checking」の状態ではない。
    // "failed"       : 接続の1つ以上のICEトランスポートが「失敗」状態になっている。
    // see : https://developer.mozilla.org/en-US/docs/Web/API/RTCPeerConnection/connectionState
  }; // Track イベントが発生したときのイベントハンドラ
  // - このイベントは、新しい着信MediaStreamTrackが作成され、
  //   コネクション上のレシーバーセットに追加されたRTCRtpReceiverオブジェクトに関連付けられたときに送信される。
  //   see : https://developer.mozilla.org/en-US/docs/Web/API/RTCPeerConnection/ontrack
  // - 古くは、rtcPeerConnection.onaddstream に設定していたが、廃止された。
  //   現在は、rtcPeerConnection.ontrack に設定する。


  rtcPeerConnection.ontrack = function (event) {
    console.log("Event : Track");
    console.log("- stream", event.streams[0]);
    console.log("- track", event.track); // HTML要素へのリモートメディアストリームの設定

    var stream = event.streams[0];
    var track = event.track;

    if ("video" === track.kind) {
      console.log("Call : setStreamToElement( Video_Remote, stream )");
      (0,_video_js__WEBPACK_IMPORTED_MODULE_1__.setStreamToElement)(_client_js__WEBPACK_IMPORTED_MODULE_2__.g_elementVideoRemote, stream);
    } else if ("audio" === track.kind) {
      console.log("Call : setStreamToElement( Audio_Remote, stream )");
      (0,_video_js__WEBPACK_IMPORTED_MODULE_1__.setStreamToElement)(_client_js__WEBPACK_IMPORTED_MODULE_2__.g_elementAudioRemote, stream);
    } else {
      console.error("Unexpected : Unknown track kind : ", track.kind);
    }
  };
};

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module is referenced by other modules so it can't be inlined
/******/ 	var __webpack_exports__ = __webpack_require__("./src/client.js");
/******/ 	mywebrtc = __webpack_exports__;
/******/ 	
/******/ })()
;