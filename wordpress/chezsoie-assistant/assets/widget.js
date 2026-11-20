(function () {
  "use strict";
  var C = window.CSA_CONFIG;
  if (!C) return;

  var path = location.pathname;
  var page = /\/(fr\/emplois|en\/jobs)(\/|$)/.test(path) ? "emplois" : "accueil";
  var en = /^\/en(\/|$)/.test(path);

  var GREET = {
    accueil: en
      ? "Hello! I'm the Chez Soie dentisterie assistant. I can answer your questions about our services, hours and appointments.\n\nBonjour! Je peux aussi vous aider en français."
      : "Bonjour! Je suis l'assistant de Chez Soie dentisterie. Je peux répondre à vos questions sur nos services, nos heures et les rendez-vous.\n\nHello! I can also help in English.",
    emplois: en
      ? "Hello! Thinking of joining the Chez Soie team? I can tell you about the clinic and what it's like to work here. To apply, send your résumé to Mélissa, our clinic manager: melissa@chezsoiedentisterie.com."
      : "Bonjour! Vous pensez à vous joindre à l'équipe Chez Soie? Je peux vous parler de la clinique et de l'ambiance de travail. Pour postuler, envoyez votre CV à Mélissa, notre gestionnaire de clinique : melissa@chezsoiedentisterie.com.\n\nThinking of joining our team? Send your résumé to Mélissa at melissa@chezsoiedentisterie.com."
  };
  var CHIPS = {
    accueil: en ? ["Book an appointment", "Dental emergency", "Opening hours", "CDCP", "New patients", "Français"]
                : ["Prendre rendez-vous", "Urgence dentaire", "Heures d'ouverture", "RCSD / CDCP", "Nouveaux patients", "English"],
    emplois: en ? ["How do I apply?", "Open positions?", "Team atmosphere", "Français"]
                : ["Comment postuler?", "Postes ouverts?", "L'ambiance d'équipe", "English"]
  };

  function el(tag, cls, text) {
    var e = document.createElement(tag);
    if (cls) e.className = cls;
    if (text != null) e.textContent = text;
    return e;
  }

  var root = el("div"); root.id = "csa-root";
  var launcher = el("button", "csa-launcher", en ? "💬 A question?" : "💬 Une question?");
  launcher.type = "button";
  var chat = el("div", "csa-chat"); chat.hidden = true;
  chat.setAttribute("role", "dialog");
  chat.setAttribute("aria-label", en ? "Chat with the assistant" : "Clavardage avec l'assistant");

  var head = el("div", "csa-head");
  var t = el("div", "csa-t");
  t.append(el("strong", null, "Assistant Chez Soie"), el("span", null, en ? "Instant answers · EN / FR" : "Réponses instantanées · FR / EN"));
  var restart = el("button", null, "↺"); restart.type = "button"; restart.title = restart.ariaLabel = en ? "New conversation" : "Nouvelle conversation";
  var close = el("button", null, "×"); close.type = "button"; close.title = close.ariaLabel = en ? "Minimize" : "Réduire";
  head.append(t, restart, close);

  var bar = el("div", "csa-bar");
  var link = el("a");
  if (page === "emplois") {
    bar.append(el("span", null, en ? "Apply: email Mélissa" : "Postuler : écrivez à Mélissa"));
    link.href = "mailto:melissa@chezsoiedentisterie.com"; link.textContent = "melissa@chezsoiedentisterie.com";
  } else {
    bar.append(el("span", null, en ? "To book, call us" : "Pour un rendez-vous, appelez-nous"));
    link.href = "tel:+1" + String(C.phone).replace(/\D/g, "").replace(/^1/, ""); link.textContent = C.phone;
  }
  bar.append(link);

  var msgs = el("div", "csa-msgs"); msgs.setAttribute("aria-live", "polite");
  var chips = el("div", "csa-chips");
  var form = el("form", "csa-form");
  var input = el("input"); input.type = "text"; input.autocomplete = "off";
  input.placeholder = en ? "Type your question…" : "Écrivez votre question…";
  input.setAttribute("aria-label", en ? "Your question" : "Votre question");
  input.maxLength = 1000;
  var send = el("button", null, en ? "Send" : "Envoyer"); send.type = "submit";
  form.append(input, send);
  var legal = el("div", "csa-legal", en
    ? "General information only, not dental advice. Please don't share health information."
    : "Information générale seulement, pas un avis dentaire. N'inscrivez pas de renseignements de santé.");

  chat.append(head);
  if (C.testMode) chat.append(el("div", "csa-test", "Mode essai : visible seulement aux administrateurs"));
  chat.append(bar, msgs, chips, form, legal);
  root.append(chat, launcher);
  document.body.appendChild(root);

  var turns = [];
  var busy = false;

  function bubble(cls, text) {
    var d = el("div", "csa-m " + cls, text);
    msgs.appendChild(d);
    msgs.scrollTop = msgs.scrollHeight;
    return d;
  }
  function greet() { msgs.textContent = ""; turns = []; bubble("csa-bot", GREET[page]); }
  CHIPS[page].forEach(function (c) {
    var b = el("button", "csa-chip", c); b.type = "button";
    b.addEventListener("click", function () { ask(c); });
    chips.appendChild(b);
  });

  function ask(text) {
    text = String(text || "").trim();
    if (!text || busy) return;
    busy = true; send.disabled = true;
    bubble("csa-me", text);
    turns.push({ role: "user", content: text });
    if (turns.length > 14) turns = turns.slice(-14);
    var wait = bubble("csa-bot csa-typing", "…");
    fetch(C.endpoint, {
      method: "POST",
      credentials: "same-origin",
      headers: { "Content-Type": "application/json", "X-WP-Nonce": C.nonce },
      body: JSON.stringify({ messages: turns, page: page })
    })
      .then(function (r) { return r.json().catch(function () { return {}; }); })
      .then(function (d) {
        var reply = d && d.reply ? String(d.reply) : (en ? "Sorry, please call us at " : "Désolé, appelez-nous au ") + C.phone + ".";
        wait.className = "csa-m csa-bot"; wait.textContent = reply;
        turns.push({ role: "assistant", content: reply });
      })
      .catch(function () {
        wait.className = "csa-m csa-bot";
        wait.textContent = (en ? "Connection problem. Please call us at " : "Problème de connexion. Appelez-nous au ") + C.phone + ".";
        turns.pop();
      })
      .then(function () { busy = false; send.disabled = false; input.focus({ preventScroll: true }); });
  }

  form.addEventListener("submit", function (e) { e.preventDefault(); var v = input.value; input.value = ""; ask(v); });
  launcher.addEventListener("click", function () { openChat(true); });
  function remember(v) { try { sessionStorage.setItem("csa_closed", v); } catch (e) {} }
  function wasClosed() { try { return sessionStorage.getItem("csa_closed") === "1"; } catch (e) { return false; } }
  function openChat(focus) { chat.hidden = false; launcher.hidden = true; if (focus) input.focus({ preventScroll: true }); }
  launcher.addEventListener("click", function () { remember("0"); });
  close.addEventListener("click", function () { chat.hidden = true; launcher.hidden = false; remember("1"); });
  restart.addEventListener("click", greet);
  greet();

  // Open by itself on page load, unless the visitor closed it earlier in this visit.
  var mobile = window.matchMedia && window.matchMedia("(max-width: 768px)").matches;
  var mode = C.autoOpen || "desktop";
  if (!wasClosed() && (mode === "all" || (mode === "desktop" && !mobile))) openChat(false);
})();
