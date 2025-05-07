window.addEventListener("DOMContentLoaded", () => {
  /*
   * Email validate
   */

  const EMAIL_REGEXP =
    /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;
  const emailInput = document.getElementById("email");
  const emailStatus = document.getElementById("email-error");

  function isEmailValid(value) {
    return EMAIL_REGEXP.test(value);
  }

  function onEmailInput() {
    if (!isEmailValid(emailInput.value)) {
      emailInput.style.borderColor = "#BA5B5B";
      emailStatus.innerText = "Invalid email format";
    } else {
      emailInput.style.borderColor = "#5B6C8C";
      emailStatus.innerText = "";
    }
  }

  emailInput.addEventListener("input", onEmailInput);

  /*
   * Name validate
   */

  const nameInput = document.getElementById("name");
  const nameStatus = document.getElementById("name-error");
  const NAME_REGEXP = /^[a-zA-Zа-яА-ЯІіЇїЄєҐґ\s']+$/;

  function isNameValid(value) {
    return NAME_REGEXP.test(value);
  }

  function onNameInput() {
    const value = nameInput.value;
    if (!isNameValid(value)) {
      nameInput.style.borderColor = "#BA5B5B";
      nameStatus.innerText = "Invalid name format";
    } else {
      nameInput.style.borderColor = "#5B6C8C";
      nameStatus.innerText = "";
    }
  }

  nameInput.addEventListener("input", onNameInput);

  /*
   * Message validate
   */

  const messageInput = document.getElementById("message");
  const messageStatus = document.getElementById("message-error");
  const MAX_LENGTH = 100;

  function isMessageValid(value) {
    return value.length > 0 && value.length <= MAX_LENGTH;
  }

  function onMessageInput() {
    const value = messageInput.value;
    if (!isMessageValid(value)) {
      messageInput.style.borderColor = "#BA5B5B";
      messageStatus.innerText = `Message must be between 1 and ${MAX_LENGTH} characters`;
    } else {
      messageInput.style.borderColor = "#5B6C8C";
      messageStatus.innerText = "";
    }
  }

  messageInput.addEventListener("input", onMessageInput);

  /*
   * Secret word generation
   */

  const words = ["Слово1", "Слово22", "Слово333", "Слово444"];
  const randomWord = words[Math.floor(Math.random() * words.length)];
  document.getElementById(
    "secret-word"
  ).innerText = `Секретне слово: ${randomWord}`;

  /*
   * Form submission
   */

  const form = document.getElementById("contactForm");
  const status = document.getElementById("status");

  const isValid =
    isNameValid(nameInput.value) &&
    isEmailValid(emailInput.value) &&
    isMessageValid(messageInput.value);

  if (!isValid) {
    status.textContent = "Форма не валідна, заповніть її корректно!";
    return;
  }

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    try {
      const response = await fetch("send.php", {
        method: "POST",
        body: formData,
      });

      if (!response.ok) {
        const errorResponse = await response.text();
        status.textContent = "Форма не відправлена: " + errorResponse;
        return;
      }

      const result = await response.text();
      status.textContent = "Форма відправлена: " + result;
    } catch (error) {
      console.error("Error:", error);
      status.textContent = "Форма не відправлена: " + error.message;
    }
  });
});
