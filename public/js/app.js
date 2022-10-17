/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
var system = {
  // Всплывающие информационные окона...
  alert: {
    timeout: 0,
    array: [],
    elem: document.getElementById('alertElem'),
    // Запуск
    run: function run(text) {
      // Если уже запущен, то ложим сообщение в архив и возвращаем.
      if (system.alert.timeout) {
        system.alert.array.push(text);
        return;
      }

      // Открываем окно
      system.alert.elem.innerText = text;
      system.alert.elem.classList.add('alerton');

      // Закрываем его через 1500.
      system.alert.timeout = setTimeout(function () {
        system.alert.elem.classList.remove('alerton');
        system.alert.timeout = 0;

        // Если в очереди что-то есть, то перезапускаем окно.
        if (system.alert.array.length) {
          setTimeout(function () {
            system.alert.run(system.alert.array.shift());
          }, 250);
          return;
        }

        // Если очередь пуста, то закрываем до конца.
        setTimeout(function () {
          system.alert.elem.innerText = '';
        }, 400);
      }, 1500);
    }
  },
  modal: {
    elem: document.getElementById('modalContainer'),
    body: document.getElementById('modalBody'),
    open: function open(html) {
      system.modal.elem.classList.remove('d-none');
      system.modal.body.innerHTML = html;
    },
    close: function close() {
      system.modal.body.innerHTML = '';
      system.modal.elem.classList.add('d-none');
    }
  },
  formFiller: {
    errorToForm: function errorToForm(r) {
      var errors = r.response.data.errors;
      var form = document.getElementById('creationForm');
      form.querySelectorAll('input[placeholder]').forEach(function (input) {
        if (errors[input.name]) {
          input.classList.add('is-invalid');
          input.nextElementSibling.innerText = errors[input.name];
        } else {
          input.classList.remove('is-invalid');
        }
      });
    },
    fromForm: function fromForm(form) {
      var data = {};
      Array.from(new FormData(form)).forEach(function (one) {
        data[one[0]] = one[1];
      });
      return data;
    }
  },
  // Название поля, которое комментируем.
  lastField: '',
  // Для предотвращения двойных нажатий.
  loading: false
};
window.system = system;

// Удалям компанию из списка.
system.eventType_deleteCompany = function (target) {
  var companyElem = target.closest('[id]');
  var name = companyElem.querySelector('[data-name]').innerText;
  if (!confirm("\u041F\u043E\u0434\u0442\u0432\u0435\u0440\u0434\u0438\u0442\u0435 \u0443\u0434\u0430\u043B\u0435\u043D\u0438\u0435 \u043A\u043E\u043C\u043F\u0430\u043D\u0438\u0438 \"".concat(name, "\""))) {
    return false;
  }
  axios["delete"]('/api/company/' + companyElem.dataset['id']).then(function (response) {
    system.alert.run('Удалено');
    companyElem.remove();
  }, function (response) {
    system.alert.run('Ошибка');
  });
};

// Удалям коментарий из списка.
system.eventType_deleteComment = function (target) {
  if (!confirm('Подтвердите удаление комментария')) {
    return false;
  }
  var commentElem = target.closest('[data-id]');
  var id = commentElem.dataset.id;
  axios["delete"]("/api/comment/".concat(id)).then(function (response) {
    system.alert.run('Удалено');
    commentElem.remove();
  }, function (response) {
    system.alert.run('Ошибка');
  });
};

// Сохраняем новую компанию.
system.eventType_companySave = function () {
  if (system.loading) return;
  system.loading = true;
  var data = system.formFiller.fromForm(document.forms.creationForm);
  axios.post('/api/company', data).then(function (r) {
    document.getElementById('companies-list').innerHTML += r.data;
    system.modal.close();
    system.alert.run('Компания создана');
  }, function (r) {
    system.formFiller.errorToForm(r);
  })["finally"](function () {
    system.loading = false;
  });
};

// Создаем новый коммент.
system.eventType_commentSave = function () {
  if (system.loading) return;
  system.loading = true;
  var data = system.formFiller.fromForm(document.forms.creationForm);
  var field = system.lastField;
  if (field) {
    data['field'] = field;
  }
  var id = document.querySelector('[data-id]').dataset['id'];
  axios.post("/api/company/".concat(id, "/comment"), data).then(function (r) {
    document.getElementById("comments-".concat(field)).innerHTML += r.data;
    system.modal.close();
    system.alert.run('Комментарий сохранен');
  }, function (r) {
    system.formFiller.errorToForm(r);
  })["finally"](function () {
    system.loading = false;
  });
};

// Открывает мадальное окно с формой.
system.eventType_companyNewOpen = function () {
  system.modal.open(document.getElementById('creationForm').outerHTML);
};

// Открывает мадальное окно с формой.
system.eventType_commentNewOpen = function (target) {
  system.lastField = target.closest('[data-field]').dataset['field'];
  system.eventType_companyNewOpen();
};
window.onload = function () {
  // Будем ловить события нажатия.
  document.addEventListener('click', function (event) {
    // Ловятся только те, что имеют структуру
    //  <div data-role="menu-navigator">
    //      <div data-type="eventName">ELEMENT</div>
    //  </div>
    var navigator = event.target.closest('[data-role="menu-navigator"]');
    var target = event.target.closest('[data-type]');
    if (!navigator || !target || !navigator.contains(target)) return;
    var eventType = 'eventType_' + target.dataset['type'];
    if (!system[eventType]) return;
    event.preventDefault();

    // Если у навигатора есть beforeCallback, то запускаем.
    if (navigator.dataset['nav']) {
      var navMethod = 'navigator_' + navigator.dataset['nav'];
      if (system[navMethod] && !system[navMethod](target)) return;
    }

    // Запуск самого события.
    system[eventType](target, navigator);
  });

  // Закрываем модальное окно при клике по туману.
  document.onkeydown = function (event) {
    if (system.modal.elem.hasAttribute('hide')) return true;
    if (event.which == 13) {
      document.querySelector('#modalBody .btn').click();
      return false;
    }
    if (event.which == 27) {
      system.modal.close();
      return false;
    }
    return true;
  };

  // Авторизация AJAX.
  window.axios.get('/sanctum/csrf-cookie').then(function (response) {
    window.axios.get('/login');
  });
};
/******/ })()
;