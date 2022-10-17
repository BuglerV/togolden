var system = {
    // Всплывающие информационные окона...
	alert: {
      timeout:0,
      array:[],
	  elem: document.getElementById('alertElem'),
	  // Запуск
      run: function(text){
		// Если уже запущен, то ложим сообщение в архив и возвращаем.
        if(system.alert.timeout){
            system.alert.array.push(text);
            return;
        }
		
		// Открываем окно
        system.alert.elem.innerText = text;
        system.alert.elem.classList.add('alerton');
		
		// Закрываем его через 1500.
        system.alert.timeout = setTimeout(function(){
            system.alert.elem.classList.remove('alerton');
            system.alert.timeout = 0;
			
			// Если в очереди что-то есть, то перезапускаем окно.
            if(system.alert.array.length){
                setTimeout(function(){
                    system.alert.run(system.alert.array.shift());
                },250);
				return;
            }
			
			// Если очередь пуста, то закрываем до конца.
			setTimeout(function(){
				system.alert.elem.innerText = '';
			},400);
			
        },1500);
      }
	},
	
	modal: {
		elem: document.getElementById('modalContainer'),
		body: document.getElementById('modalBody'),
		open: function(html){
			system.modal.elem.classList.remove('d-none');
			system.modal.body.innerHTML = html;
		},
		close: function(){
			system.modal.body.innerHTML = '';
			system.modal.elem.classList.add('d-none');
		}
	},
	
	formFiller: {
		errorToForm: function(r){
			let errors = r.response.data.errors;
			let form = document.getElementById('creationForm');
			
			form.querySelectorAll('input[placeholder]').forEach(input => {
				if(errors[input.name]){
					input.classList.add('is-invalid');
					input.nextElementSibling.innerText = errors[input.name];
				}
				else{
					input.classList.remove('is-invalid');
				}
			});
		},
		fromForm: function(form){
			let data = {};
			
			Array.from((new FormData(form))).forEach(one => {
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
system.eventType_deleteCompany = function(target){
	let companyElem = target.closest('[id]');
	let name = companyElem.querySelector('[data-name]').innerText;
	
	if(!confirm(`Подтвердите удаление компании "${name}"`)){
		return false;
	}
	
	axios.delete('/api/company/' + companyElem.dataset['id'])
	.then((response) => {
		system.alert.run('Удалено');
		companyElem.remove();
	},(response) => {
		system.alert.run('Ошибка');
	});
};

// Удалям коментарий из списка.
system.eventType_deleteComment = function(target){
	if(!confirm('Подтвердите удаление комментария')){
		return false;
	}
	
	let commentElem = target.closest('[data-id]');
	let id = commentElem.dataset.id;

	axios.delete(`/api/comment/${id}`)
	.then((response) => {
		system.alert.run('Удалено');
		commentElem.remove();
	},(response) => {
		system.alert.run('Ошибка');
	});
};

// Сохраняем новую компанию.
system.eventType_companySave = function(){
	if(system.loading) return;
	
	system.loading = true;
	
	let data = system.formFiller.fromForm(document.forms.creationForm);
	
	axios.post('/api/company',data).then(r => {
		document.getElementById('companies-list').innerHTML += r.data;
		system.modal.close();
		system.alert.run('Компания создана');
	},r => {
		system.formFiller.errorToForm(r);
	}).finally(function(){
		system.loading = false;
	});
};

// Создаем новый коммент.
system.eventType_commentSave = function(){
	if(system.loading) return;
	system.loading = true;
	
	let data = system.formFiller.fromForm(document.forms.creationForm);
	let field = system.lastField;
	if(field){
		data['field'] = field;
	}
	
	let id = document.querySelector('[data-id]').dataset['id'];
	
	axios.post(`/api/company/${id}/comment`,data).then(r => {
		document.getElementById(`comments-${field}`).innerHTML += r.data;
		system.modal.close();
		system.alert.run('Комментарий сохранен');
	},r => {
		system.formFiller.errorToForm(r);
	}).finally(function(){
		system.loading = false;
	});
};

// Открывает мадальное окно с формой.
system.eventType_companyNewOpen = function(){
	system.modal.open(document.getElementById('creationForm').outerHTML);
};

// Открывает мадальное окно с формой.
system.eventType_commentNewOpen = function(target){
	system.lastField = target.closest('[data-field]').dataset['field'];
	system.eventType_companyNewOpen();
};



  window.onload = function(){
	  // Будем ловить события нажатия.
      document.addEventListener('click',function(event){
		// Ловятся только те, что имеют структуру
		//  <div data-role="menu-navigator">
		//      <div data-type="eventName">ELEMENT</div>
		//  </div>
        let navigator = event.target.closest('[data-role="menu-navigator"]');
        let target = event.target.closest('[data-type]');
        
        if(!navigator || !target || !navigator.contains(target)) return;
        
        let eventType = 'eventType_'+target.dataset['type'];
        if(!system[eventType]) return;

        event.preventDefault();

        // Если у навигатора есть beforeCallback, то запускаем.
        if(navigator.dataset['nav']){
          let navMethod = 'navigator_' + navigator.dataset['nav'];
          if(system[navMethod] && !system[navMethod](target)) return;
        }

        // Запуск самого события.
        system[eventType](target,navigator);
      });
      
	  // Закрываем модальное окно при клике по туману.
      document.onkeydown = function(event){
          if(system.modal.elem.hasAttribute('hide')) return true;
		  
		  if(event.which == 13){
			  document.querySelector('#modalBody .btn').click();
			  return false;
		  }
		  
		  if(event.which == 27){
			  system.modal.close();
			  return false;
		  }
          return true;
      }
	  
	  // Авторизация AJAX.
	  window.axios.get('/sanctum/csrf-cookie').then(response => {
		  window.axios.get('/login');
	  });
  };