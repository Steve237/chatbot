$("#send").on("click", function () {
  let question = $("#userInput").val();
  let chatContainer = $("#body");
  let userHtml =
    '<div class="userSection">' +
    '<div class="messages user-message">' +
    question +
    "</div>" +
    '<div class="seperator"></div>' +
    "</div>";
  $("#body").append(userHtml);

  let waitingMessage =
    '<div class="userSection waitingMessage">' +
    '<div class="messages user-message"> Veuillez patienter, nous recherchons une réponse... </div>' +
    '<div class="seperator"></div>' +
    "</div>";
  $("#body").append(waitingMessage);

  $.ajax({
    type: "POST",
    url: window.location.origin + "/chatbot-response",
    dataType: "json",
    data: {
      messageValue: question,
    },
    beforeSend: function () {
      $("#userInput").val("");
      chatContainer.scrollTop(chatContainer[0].scrollHeight);
    },
    success: function (response) {
      $(".waitingMessage").css("display", "none");
      let botHtml =
        '<div class="botSection">' +
        '<div class="messages bot-reply">' +
        response.message +
        "</div>" +
        '<div class="seperator"></div>' +
        "</div>";
      $("#body").append(botHtml);
    },
  });
});
