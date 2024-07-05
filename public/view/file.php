<style>
html,body{height:100%}.flex{display:flex;align-items:center;justify-content:center;flex-direction:column}#pdfContainer{width:100%}input[type="file"]{width:0;height:0}#fileLabel{width:300px;height:120px;font-size:24px;border:5px #333 dotted;display:flex;align-items:center;justify-content:center;text-transform:uppercase;max-width:100%;cursor:pointer}.myMenuContainer{list-style:none;margin:0;padding:0;width:150px;overflow:hidden}.contextMenu-item{width:100%;background:none;margin:5px 0;cursor:pointer;padding:3px 8px;color:#fff}.contextMenu-button{background:none;display:flex;align-items:center;width:100%;border:none;font-size:15px;padding:5px 0;cursor:pointer;color:#fff}.contextMenu-item:hover .contextMenu-button{color:#000}.contextMenu-item:hover{background:#eee;color:#000}.menuList{width:100%;display:flex;position:relative;padding:10px 20px;background:#eee}#contextContainer{display:flex;justify-content:flex-start;width:100%;gap:20px;flex-wrap:wrap;h2{font-size:30px;margin-bottom:8px}p{font-size:19px;margin:0}}.clearBtn{background:red;color:#fff;padding:7px 10px;width:auto;border:none;position:absolute;cursor:pointer;top:10px;right:40px}
</style>


<div id="pdfContainer" height="{{ $height }}" oncontextmenu="return false">
    <iframe src="/iframe" frameborder="0" width="100%" height="{{ $height }}"></iframe>
</div>

<div class="menuList">
    <div id="contextContainer"></div>
    <button class="clearBtn">Clear All</button>
</div>


<script>
    let selector = document.getElementById("fileLabel");
      let menuLength = 0;
      let menuEnd = false;

      let   menuX = document.createElement("div");
      menuX.classList.add("contextBox");
            document.querySelector("#pdfContainer").append(menuX);

            function getSelectedText() {
        if (window.getSelection) {
          return window.getSelection().toString();
        } else if (document.selection) {
          console.log(document.selection.createRange())
          return document.selection.createRange().text;
        }
        return "";
      }

      let menuIndex = [];
      let rightIndex = 0;
      const menu = ["Rony", "Jony", "Mony", "Tony", "Fony"];
      const options = [
        ["Gello Jony", "Hello Rony", "Dekho Mony", "Jao Tony", "Asho Fony"],
        ["Jao Tony", "Hello Rony", "Gello Jony", "Dekho Mony", "Asho Fony"],
        ["Dekho Mony", "Hello Rony", "Gello Jony", "Jao Tony", "Asho Fony"],
        ["Hello Rony", "Gello Jony", "Dekho Mony", "Jao Tony", "Asho Fony"],
        ["Asho Fony", "Hello Rony", "Gello Jony", "Dekho Mony", "Jao Tony"],
      ];


      document.addEventListener("contextmenu", (e) => {
        rightIndex++;
        var text = getSelectedText();
        let container = document.querySelector("#pdfContainer");
        let originalText = e.originalTarget;
        const {clientX,clientY, clientWidth} = e;
        let clientTop = styleSanitizer(originalText.parentElement.getAttribute('style'));
        let item = document.createElement('div');
            item.style.cssText = `background:#fff;height:40px;left:${clientX - 20}px;top:${clientTop};color:#000;font-size:35px;`;
            item.textContent = rightIndex;
        container.appendChild(item);
        if (text != "") {
          rightOptions(".contextBox", container, e, menu, options, rightIndex +". "+ text);
        }
      });

      document.addEventListener('click',()=>{
        setSelectedText();
      })

      document.querySelector('.clearBtn').addEventListener('click',()=>{
        console.log('ok')
        sessionStorage.removeItem("selectItems");
        setSelectedText();
      })

      function setSelectedText() {
        let items = JSON.parse(sessionStorage.getItem("selectItems"));
        let exLength = menuLength;
        menuLength = (items && items.length != menuLength) ? items.length : menuLength;

        if (items != undefined && Array.isArray(items) && menuLength !== 0) {
          if(!menuEnd | exLength != menuLength){
            $('#contextContainer').html("");
            items.forEach((item) => {
              let newMenu = '';
              let subMenu = '';
              for(const text in item){
                if(text !== 'h2'){
                  subMenu += `<p>${item[text]}</p>`;
                }else{
                  newMenu = `<h2>${item.h2}</h2>`;
                }
              }
              $('#contextContainer').append(`<div>${newMenu+subMenu}</div>`);
            });
          }
          menuEnd = true;
        }else{
          if(items == undefined){
            $('#contextContainer').html("");
          }
        }
        menuEnd = (items && items.length != menuLength) ? false : true;
      }

      setSelectedText();

      function styleSanitizer(styles){
        var str = styles.split(';');
        let splY=  0;
        if(str.length > 0){
          str.forEach(item => {
            let spl = item.split(":");
            if(spl[0].trim() == 'top'){
              splY = spl[1];
            }
          })
        }
        return splY;
      }

      function rightOptions(item, container, events, menu, options, text) {
        class ContextMenu {
          constructor({
            target = null,
            menuItems = [],
            mode = null,
            box = null,
            events,
            options,
            text,
          }) {
            this.target = target;
            this.menuItems = menuItems;
            this.mode = mode;
            this.box = box;
            this.targetNode = this.getTargetNode();
            this.menuItemsNode = this.getMenuItemsNode();
            this.isOpened = false;
            this.events = events;
            this.menuHeight = 0;
            this.activeHover = false;
            this.options = options;
            this.text = text;
          }

          getTargetNode() {
            const nodes = this.box.querySelectorAll(this.target);
            if (nodes && nodes.length !== 0) {
              return nodes;
            } else {
              console.error(
                `getTargetNode :: "${this.target}" target not found`
              );
              return [];
            }
          }

          getMenuItemsNode() {
            const nodes = [];

            if (!this.menuItems) {
              console.error("getMenuItemsNode :: Please enter menu items");
              return [];
            }

            this.menuItems.forEach((data, index) => {
              const item = this.createItemMarkup(data, index);
              item.firstChild.setAttribute(
                "style",
                `animation-delay: ${index * 0.08}s`
              );
              nodes.push(item);
            });
            return nodes;
          }

          createItemMarkup(data, index) {
            const button = document.createElement("BUTTON");
            const item = document.createElement("LI");

            button.innerHTML = data.content;
            button.classList.add("contextMenu-button");
            item.classList.add("contextMenu-item");
            item.setAttribute("data-index", index);

            if (data.divider) item.setAttribute("data-divider", data.divider);
            item.appendChild(button);

            item.addEventListener("mouseleave", (e) => {
              this.activeHover = false;
              this.closeSubMenu();
            });

            item.addEventListener("mouseenter", (e) => {
              this.activeHover = true;
              const index = e.target.getAttribute("data-index");
              let textItem = this.options[index];
              document.querySelector(".contextMenu").style.width = "340px";
              document.querySelector(".hoverSubMenu").style.width = "250px";
              let boxOptions = "";
              textItem.forEach((item, index) => {
                boxOptions += `<div data-id='myMenuContext' style='display:flex;align-items:center;justify-content:flex-start;gap:10px;margin:5px 0px;cursor:pointer;'><input data-id='myMenuContext' type='checkbox' value='${item}' id='item${index}' class='subMenuContextItem' /> <label data-id='myMenuContext' for="item${index}">${item}</label></div>`;
              });
              document.querySelector(".hoverSubMenu").innerHTML = boxOptions;
            });

            item.setAttribute("data-id", "myMenuContext");

            if (data.events && data.events.length !== 0) {
              Object.entries(data.events).forEach((event) => {
                const [key, value] = event;
                button.addEventListener(key, value);
              });
            }

            return item;
          }

          closeSubMenu() {
            let cTime = 0;
            const timer = setInterval(() => {
              cTime++;
              if (cTime == 1) {
                cTime = 0;
                clearInterval(timer);
                if (!this.activeHover) {
                  document.querySelector(".contextMenu").style.width = "150px";
                  document.querySelector(".hoverSubMenu").style.width = "0px";
                  document.querySelector(".hoverSubMenu").innerHTML = "";
                }
              }
            }, 1000);
          }

          renderMenu() {
            const Menu = document.createElement("div");
            Menu.style.cssText =
              "display:flex;align-items:center;justify-content:space-between;width:450px;";
            const menuContainer = document.createElement("UL");
            menuContainer.classList.add("myMenuContainer");
            const subMenu = document.createElement("div");
            subMenu.style.cssText = `width:0px;display:flex;flex-direction:column;padding:5px;background:#ddd;color:#000;height: 0px;transition: width 0.2s`;
            subMenu.classList.add("hoverSubMenu");
            subMenu.addEventListener("mouseenter", () => {
              this.activeHover = true;
            });
            subMenu.addEventListener("mousemove", () => {
              this.activeHover = true;
              console.log(this.activeHover);
            });
            subMenu.addEventListener("touchmove", () => {
              this.activeHover = true;
            });

            Menu.classList.add("contextMenu");
            Menu.setAttribute("data-theme", this.mode);
            Menu.setAttribute("data-id", "myMenuContext");
            subMenu.setAttribute("data-id", "myMenuContext");
            menuContainer.setAttribute("data-id", "myMenuContext");
            Menu.appendChild(menuContainer);
            Menu.appendChild(subMenu);

            this.menuItemsNode.forEach((item) =>
              menuContainer.appendChild(item)
            );
            return Menu;
          }

          closeMenu(menu) {
            if (this.isOpened && !this.activeHover) {
              this.isOpened = false;
              menu.remove();
            }
          }

          init() {
            const contextMenu = this.renderMenu();
            document.addEventListener("click", (e) => {
              var rootID = e.target.getAttribute("data-id");
              if ((rootID !== "myMenuContext") | (rootID === undefined)) {
                if (this.text) {

                  console.log(this.events.target.innerHTML);
                  let textItems = {};
                  textItems.h2 = this.text
                  this.text = undefined;

                  let checkBox = document.querySelectorAll(
                    ".subMenuContextItem"
                  );
                  checkBox.forEach((item,index) => {
                    if (item.checked) {
                      textItems[index] = item.value
                    }
                  });

                  let exItem =
                    JSON.parse(sessionStorage.getItem("selectItems")) ?? [];
                  exItem.push(textItems);
                  sessionStorage.setItem("selectItems", JSON.stringify(exItem));
                }
                this.activeHover = false;
                this.closeMenu(contextMenu);
              }
            });
            window.addEventListener("blur", () => this.closeMenu(contextMenu));
            document.addEventListener("contextmenu", (e) => {
              this.targetNode.forEach((target) => {
                if (!e.target.contains(target)) {
                  contextMenu.remove();
                }
              });
            });

            if (typeof this.events === "object") {
              this.events.preventDefault();
              this.isOpened = true;

              const { clientX, clientY } = this.events;
              console.log(
                clientX,
                clientY,
                contextMenu.scrollWidth,
                window.innerWidth
              );
              this.box.append(contextMenu);
              const positionY =
                clientY + contextMenu.scrollHeight >= window.innerHeight
                  ? window.innerHeight - contextMenu.scrollHeight - 20
                  : clientY;
              const positionX = clientX;

              this.menuHeight = contextMenu.scrollHeight;

              contextMenu.style.cssText = `width: 150px;height${this.menuHeight}px;top:${positionY}px;left:${positionX}px;z-index:999999999;position:absolute;background:rgba(0,0,0,.7);margin-left:5px;list-style:none;padding:0px;border-radius:12px;display:flex;align-items:center;justify-content:space-between;color:#fff;`;
              document.querySelector(".hoverSubMenu").style.height =
                this.menuHeight + "px";
            }
          }
        }

        const hostURL = "https://abdursoft.com/";
        const menuItems = [];
        menu.forEach((item) => {
          menuItems.push({ content: item });
        });

        const dark = new ContextMenu({
          target: item,
          menuItems,
          mode: "dark",
          box: container,
          events: events,
          options,
          text,
        });
        if(document.location.hostname == '127.0.0.1' | document.location.hostname == 'localhost' | document.location.hostname == 'pdf.abdursoft.com' | document.location.hostname == 'meaadamo.com' | document.location.hostname == 'fujicotech.com'){
          dark.init();
          function removeMessage() {
            const message = container.querySelector(".right-click");
            if (message) message.remove();
          }
          window.addEventListener("click", removeMessage);
          window.addEventListener("contextmenu", removeMessage);
        }

      }
</script>