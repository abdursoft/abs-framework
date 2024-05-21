/* CopyRight By Abdursoft.com
*
*ABS Video Player
*Plugin Name: absRadio Player
*Plugin URI: https://abdursoft.com/
*Description: Premium radio player is a music player that will perform on your live radio.  
              This one  comes with 3 player skin such as large,small and fixed. It will read live  meta-data from radio station like current song title,artwork,artist etc.
*
*Version: 1.0.6
*Author: Abdur 
*Author URI: https://abdursoft.com/about
*License: abdursoft.com
*Text Domain: abdurSoft
*
*Developed By Abdur Rahim


/******************
Any software developed by abdursoft.com and any software provided to you in conjunction with providing the Service is protected by copyright law and international treaty provisions. You may not copy/redistribute the software or any portion of it.

Otherwise abdursoft.com will take action against you by the law of copyright.Stay safe and enjoy your video streaming.
******************/


(function (e) {
    e.fn.absVideo = function (t) {
        var absPlayer = e.extend(
            {
                src: "",
                encrypt: "",
                poster: "",
                autoplay: "",
                playback: "",
                loop: "",
                share: false,
                height: "",
                width: "",
                subtitle: "",
                logo: "",
                snap: false,
                api_key: "",
                vast: '',
                forward: false,
                backward: false,
                v360: false,
            },
            t
        );

        const def = {
            http: "http://",
            https: "https://",
            host: "api.abdursoft.com/",
            icons: {
                playBtn:
                    '<svg width="25px" height="25px"  viewBox="0 0 24 24"><path fill="currentColor" d="M8,5.14V19.14L19,12.14L8,5.14Z"></path></svg>',
                pauseBtn:
                    '<svg  width="25px" height="25px" viewBox="0 0 24 24"><path fill="currentColor" d="M14,19H18V5H14M6,19H10V5H6V19Z"></path></svg>',
                faullScreenEnter:
                    '<svg  width="25px" height="25px" viewBox="0 0 24 24"><path fill="currentColor" d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"></path></svg>',
                fullScreenOut:
                    '<svg  width="25px" height="25px" viewBox="0 0 24 24"><path fill="currentColor" d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z"></path></svg>',
                rightArrow:
                    '<svg version="1.1" dth="12px" fill="#fff" height="12px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 59.414 59.414" style="enable-background:new 0 0 59.414 59.414;" xml:space="preserve"><polygon points="15.561,0 14.146,1.414 42.439,29.707 14.146,58 15.561,59.414 45.268,29.707 "/></svg>',
                muteBtn:
                    '<svg width="25px" height="25px" viewBox="0 0 24 24"><path fill="currentColor" d="M12,4L9.91,6.09L12,8.18M4.27,3L3,4.27L7.73,9H3V15H7L12,20V13.27L16.25,17.53C15.58,18.04 14.83,18.46 14,18.7V20.77C15.38,20.45 16.63,19.82 17.68,18.96L19.73,21L21,19.73L12,10.73M19,12C19,12.94 18.8,13.82 18.46,14.64L19.97,16.15C20.62,14.91 21,13.5 21,12C21,7.72 18,4.14 14,3.23V5.29C16.89,6.15 19,8.83 19,12M16.5,12C16.5,10.23 15.5,8.71 14,7.97V10.18L16.45,12.63C16.5,12.43 16.5,12.21 16.5,12Z"></path></svg>',
                soundLower:
                    '<svg width="25px" height="25px" viewBox="0 0 24 24"><path fill="currentColor" d="M5,9V15H9L14,20V4L9,9M18.5,12C18.5,10.23 17.5,8.71 16,7.97V16C17.5,15.29 18.5,13.76 18.5,12Z"></path></svg>',
                soundHigher:
                    '<svg width="25px" height="25px" viewBox="0 0 24 24"><path fill="currentColor" d="M14,3.23V5.29C16.89,6.15 19,8.83 19,12C19,15.17 16.89,17.84 14,18.7V20.77C18,19.86 21,16.28 21,12C21,7.72 18,4.14 14,3.23M16.5,12C16.5,10.23 15.5,8.71 14,7.97V16C15.5,15.29 16.5,13.76 16.5,12M3,9V15H7L12,20V4L7,9H3Z"></path></svg>',
                moveForward: 
                    `<svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M14.4314 16.9203H12.1414C11.7314 16.9203 11.3914 16.5803 11.3914 16.1703C11.3914 15.7603 11.7314 15.4203 12.1414 15.4203H14.4314C14.8614 15.4203 15.2114 15.0703 15.2114 14.6403C15.2114 14.2103 14.8614 13.8603 14.4314 13.8603H12.1414C11.9014 13.8603 11.6714 13.7403 11.5314 13.5503C11.3914 13.3603 11.3514 13.1003 11.4314 12.8703L12.1914 10.5803C12.2914 10.2703 12.5814 10.0703 12.9014 10.0703H15.9614C16.3714 10.0703 16.7114 10.4103 16.7114 10.8203C16.7114 11.2303 16.3714 11.5703 15.9614 11.5703H13.4414L13.1814 12.3603H14.4314C15.6914 12.3603 16.7114 13.3803 16.7114 14.6403C16.7114 15.9003 15.6814 16.9203 14.4314 16.9203Z" fill="#ffffff"></path> <path d="M9.54041 16.9208C9.13041 16.9208 8.79041 16.5808 8.79041 16.1708V12.7808L8.60041 13.0008C8.32041 13.3108 7.85041 13.3308 7.54041 13.0608C7.24041 12.7808 7.21041 12.3108 7.49041 12.0008L8.99041 10.3308C9.20041 10.1008 9.53041 10.0208 9.82041 10.1308C10.1104 10.2408 10.3004 10.5208 10.3004 10.8308V16.1808C10.2904 16.5908 9.96041 16.9208 9.54041 16.9208Z" fill="#ffffff"></path> <path d="M19.6916 7.3488C19.4416 7.0188 18.9716 6.9488 18.6416 7.1988C18.3116 7.4488 18.2416 7.9188 18.4916 8.2488C19.5716 9.6888 20.1416 11.3688 20.1416 13.1088C20.1416 17.5988 16.4916 21.2488 12.0016 21.2488C7.51156 21.2488 3.86156 17.5988 3.86156 13.1088C3.86156 8.6188 7.51156 4.9788 12.0016 4.9788C12.5816 4.9788 13.1716 5.0488 13.8116 5.1988C13.8416 5.2088 13.8716 5.1988 13.9016 5.1988C13.9316 5.1988 13.9516 5.2188 13.9716 5.2188C14.0016 5.2188 14.0216 5.2088 14.0516 5.2088C14.0816 5.2088 14.1116 5.1988 14.1516 5.1888C14.2116 5.1788 14.2616 5.1488 14.3116 5.1288C14.3416 5.1088 14.3716 5.0988 14.4016 5.0788C14.4116 5.0688 14.4316 5.0688 14.4416 5.0588C14.4716 5.0388 14.4816 5.0088 14.5016 4.9888C14.5416 4.9488 14.5716 4.9188 14.6016 4.8688C14.6316 4.8288 14.6416 4.7788 14.6616 4.7288C14.6716 4.6988 14.6916 4.6688 14.7016 4.6388C14.7016 4.6188 14.7016 4.6088 14.7016 4.5888C14.7116 4.5388 14.7116 4.4888 14.7016 4.4388C14.7016 4.3888 14.7016 4.3488 14.6916 4.2988C14.6816 4.2588 14.6616 4.2188 14.6416 4.1688C14.6216 4.1188 14.6016 4.0688 14.5716 4.0288C14.5716 4.0188 14.5716 4.0088 14.5616 3.9988L12.5816 1.5288C12.3216 1.2088 11.8516 1.1488 11.5316 1.4088C11.2116 1.6688 11.1616 2.1388 11.4116 2.4588L12.2316 3.4788C12.1516 3.4788 12.0716 3.4688 11.9916 3.4688C6.68156 3.4688 2.35156 7.7888 2.35156 13.1088C2.35156 18.4288 6.67156 22.7488 11.9916 22.7488C17.3116 22.7488 21.6316 18.4288 21.6316 13.1088C21.6416 11.0388 20.9616 9.0488 19.6916 7.3488Z" fill="#ffffff"></path> </g></svg>`,
                moveBackward: 
                    `<svg viewBox="0 0 24 24" width="25px" height="25px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15.96 10.8301H12.9L12.14 13.1201H14.43C15.27 13.1201 15.96 13.8001 15.96 14.6501C15.96 15.4901 15.28 16.1801 14.43 16.1801H12.14" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9.54004 16.17V10.8301L8.04004 12.5001" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M10.02 4.46997L12 2" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4.90997 7.79999C3.79997 9.27999 3.10999 11.11 3.10999 13.11C3.10999 18.02 7.09 22 12 22C16.91 22 20.89 18.02 20.89 13.11C20.89 8.19999 16.91 4.21997 12 4.21997C11.32 4.21997 10.66 4.31002 10.02 4.46002" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>`,
                playlist:
                    '<svg fill="#ffffff" width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M13 16.493C13 18.427 14.573 20 16.507 20s3.507-1.573 3.507-3.507c0-.177-.027-.347-.053-.517H20V6h2V4h-3a1 1 0 0 0-1 1v8.333a3.465 3.465 0 0 0-1.493-.346A3.51 3.51 0 0 0 13 16.493zM2 5h14v2H2z"></path><path d="M2 9h14v2H2zm0 4h9v2H2zm0 4h9v2H2z"></path></g></svg>',
                backBtn:
                    '<svg version="1.1" id="Capa_1" width="12px" height="12px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 197.402 197.402" style="enable-background:new 0 0 197.402 197.402;" xml:space="preserve"> <g> <g> <g> <polygon style="fill:#fff;" points="146.883,197.402 45.255,98.698 146.883,0 152.148,5.418 56.109,98.698 152.148,191.98  "/> </g> </g> </g> </svg>',
                settings:
                    '<svg version="1.1" width="35px" height="35px" viewBox="0 0 36 36"><use class="ytp-svg-shadow" xlink:href="#ytp-id-54"></use><path d="m 23.94,18.78 c .03,-0.25 .05,-0.51 .05,-0.78 0,-0.27 -0.02,-0.52 -0.05,-0.78 l 1.68,-1.32 c .15,-0.12 .19,-0.33 .09,-0.51 l -1.6,-2.76 c -0.09,-0.17 -0.31,-0.24 -0.48,-0.17 l -1.99,.8 c -0.41,-0.32 -0.86,-0.58 -1.35,-0.78 l -0.30,-2.12 c -0.02,-0.19 -0.19,-0.33 -0.39,-0.33 l -3.2,0 c -0.2,0 -0.36,.14 -0.39,.33 l -0.30,2.12 c -0.48,.2 -0.93,.47 -1.35,.78 l -1.99,-0.8 c -0.18,-0.07 -0.39,0 -0.48,.17 l -1.6,2.76 c -0.10,.17 -0.05,.39 .09,.51 l 1.68,1.32 c -0.03,.25 -0.05,.52 -0.05,.78 0,.26 .02,.52 .05,.78 l -1.68,1.32 c -0.15,.12 -0.19,.33 -0.09,.51 l 1.6,2.76 c .09,.17 .31,.24 .48,.17 l 1.99,-0.8 c .41,.32 .86,.58 1.35,.78 l .30,2.12 c .02,.19 .19,.33 .39,.33 l 3.2,0 c .2,0 .36,-0.14 .39,-0.33 l .30,-2.12 c .48,-0.2 .93,-0.47 1.35,-0.78 l 1.99,.8 c .18,.07 .39,0 .48,-0.17 l 1.6,-2.76 c .09,-0.17 .05,-0.39 -0.09,-0.51 l -1.68,-1.32 0,0 z m -5.94,2.01 c -1.54,0 -2.8,-1.25 -2.8,-2.8 0,-1.54 1.25,-2.8 2.8,-2.8 1.54,0 2.8,1.25 2.8,2.8 0,1.54 -1.25,2.8 -2.8,2.8 l 0,0 z" fill="#fff" id="ytp-id-54"></path></svg>',
                snapIcon:
                    '<svg width="22px" fill="#fff" height="22px" viewBox="0 0 28 28" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="ic_fluent_camera_28_filled" fill="#fff" fill-rule="nonzero"> <path d="M16.9510797,2.50304787 C17.7274884,2.50304787 18.4490393,2.9033378 18.8600157,3.56205529 L20.3810589,6 L22.75,6 C24.5449254,6 26,7.45507456 26,9.25 L26,21.75 C26,23.5449254 24.5449254,25 22.75,25 L5.25,25 C3.45507456,25 2,23.5449254 2,21.75 L2,9.25 C2,7.45507456 3.45507456,6 5.25,6 L7.81851226,6 L9.2010861,3.62210494 C9.60389995,2.92930357 10.3448058,2.50304787 11.1462,2.50304787 L16.9510797,2.50304787 Z M14,9.50268415 C10.9624339,9.50268415 8.5,11.965118 8.5,15.0026842 C8.5,18.0402503 10.9624339,20.5026842 14,20.5026842 C17.0375661,20.5026842 19.5,18.0402503 19.5,15.0026842 C19.5,11.965118 17.0375661,9.50268415 14,9.50268415 Z M14,11.0026842 C16.209139,11.0026842 18,12.7935452 18,15.0026842 C18,17.2118232 16.209139,19.0026842 14,19.0026842 C11.790861,19.0026842 10,17.2118232 10,15.0026842 C10,12.7935452 11.790861,11.0026842 14,11.0026842 Z" id="🎨-Color"></path> </g> </g></svg>',
                capCrossIcon:
                    '<svg version="1.1" fill="#fff" width="25px" height="25px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve"> <polygon points="11.387,490 245,255.832 478.613,490 489.439,479.174 255.809,244.996 489.439,10.811 478.613,0 245,234.161  11.387,0 0.561,10.811 234.191,244.996 0.561,479.174 " /> </svg>',
                buffuerLoader:
                    '<svg class="waitSVG" fill="#fff" x="0px" y="0px" width="100px" height="100px" viewBox="5 5 40 40"><path d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z" transform="rotate(39.9522 25 25)"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite"></animateTransform></path></svg>',
                shareIcon:
                    '<svg viewBox="-1 0 26 26" version="1.1" width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>share</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-314.000000, -728.000000)" fill="#ffffff"> <path d="M333,744 C331.23,744 329.685,744.925 328.796,746.312 L323.441,743.252 C323.787,742.572 324,741.814 324,741 C324,740.497 323.903,740.021 323.765,739.563 L329.336,736.38 C330.249,737.37 331.547,738 333,738 C335.762,738 338,735.762 338,733 C338,730.238 335.762,728 333,728 C330.238,728 328,730.238 328,733 C328,733.503 328.097,733.979 328.235,734.438 L322.664,737.62 C321.751,736.631 320.453,736 319,736 C316.238,736 314,738.238 314,741 C314,743.762 316.238,746 319,746 C320.14,746 321.179,745.604 322.02,744.962 L328.055,748.46 C328.035,748.64 328,748.814 328,749 C328,751.762 330.238,754 333,754 C335.762,754 338,751.762 338,749 C338,746.238 335.762,744 333,744" id="share" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>',
                facebookIcon:
                    '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 112.196 112.196" style="enable-background:new 0 0 112.196 112.196;" xml:space="preserve"><g><circle style="fill:#3B5998;" cx="56.098" cy="56.098" r="56.098"/><path style="fill:#FFFFFF;" d="M70.201,58.294h-10.01v36.672H45.025V58.294h-7.213V45.406h7.213v-8.34c0-5.964,2.833-15.303,15.301-15.303L71.56,21.81v12.51h-8.151c-1.337,0-3.217,0.668-3.217,3.513v7.585h11.334L70.201,58.294z"/></g></svg>',
                twitterIcon:
                    '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 112.197 112.197" style="enable-background:new 0 0 112.197 112.197;" xml:space="preserve"><g><circle style="fill:#55ACEE;" cx="56.099" cy="56.098" r="56.098"/><g><path style="fill:#F1F2F2;" d="M90.461,40.316c-2.404,1.066-4.99,1.787-7.702,2.109c2.769-1.659,4.894-4.284,5.897-7.417c-2.591,1.537-5.462,2.652-8.515,3.253c-2.446-2.605-5.931-4.233-9.79-4.233c-7.404,0-13.409,6.005-13.409,13.409c0,1.051,0.119,2.074,0.349,3.056c-11.144-0.559-21.025-5.897-27.639-14.012c-1.154,1.98-1.816,4.285-1.816,6.742c0,4.651,2.369,8.757,5.965,11.161c-2.197-0.069-4.266-0.672-6.073-1.679c-0.001,0.057-0.001,0.114-0.001,0.17c0,6.497,4.624,11.916,10.757,13.147c-1.124,0.308-2.311,0.471-3.532,0.471c-0.866,0-1.705-0.083-2.523-0.239c1.706,5.326,6.657,9.203,12.526,9.312c-4.59,3.597-10.371,5.74-16.655,5.74c-1.08,0-2.15-0.063-3.197-0.188c5.931,3.806,12.981,6.025,20.553,6.025c24.664,0,38.152-20.432,38.152-38.153c0-0.581-0.013-1.16-0.039-1.734C86.391,45.366,88.664,43.005,90.461,40.316L90.461,40.316z"/></g></g></svg>',
                redditIcon:
                    '<svg width="35px" height="35px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16 2C8.27812 2 2 8.27812 2 16C2 23.7219 8.27812 30 16 30C23.7219 30 30 23.7219 30 16C30 8.27812 23.7219 2 16 2Z" fill="#FC471E"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M20.0193 8.90951C20.0066 8.98984 20 9.07226 20 9.15626C20 10.0043 20.6716 10.6918 21.5 10.6918C22.3284 10.6918 23 10.0043 23 9.15626C23 8.30819 22.3284 7.6207 21.5 7.6207C21.1309 7.6207 20.7929 7.7572 20.5315 7.98359L16.6362 7L15.2283 12.7651C13.3554 12.8913 11.671 13.4719 10.4003 14.3485C10.0395 13.9863 9.54524 13.7629 9 13.7629C7.89543 13.7629 7 14.6796 7 15.8103C7 16.5973 7.43366 17.2805 8.06967 17.6232C8.02372 17.8674 8 18.1166 8 18.3696C8 21.4792 11.5817 24 16 24C20.4183 24 24 21.4792 24 18.3696C24 18.1166 23.9763 17.8674 23.9303 17.6232C24.5663 17.2805 25 16.5973 25 15.8103C25 14.6796 24.1046 13.7629 23 13.7629C22.4548 13.7629 21.9605 13.9863 21.5997 14.3485C20.2153 13.3935 18.3399 12.7897 16.2647 12.7423L17.3638 8.24143L20.0193 8.90951ZM12.5 18.8815C13.3284 18.8815 14 18.194 14 17.3459C14 16.4978 13.3284 15.8103 12.5 15.8103C11.6716 15.8103 11 16.4978 11 17.3459C11 18.194 11.6716 18.8815 12.5 18.8815ZM19.5 18.8815C20.3284 18.8815 21 18.194 21 17.3459C21 16.4978 20.3284 15.8103 19.5 15.8103C18.6716 15.8103 18 16.4978 18 17.3459C18 18.194 18.6716 18.8815 19.5 18.8815ZM12.7773 20.503C12.5476 20.3462 12.2372 20.4097 12.084 20.6449C11.9308 20.8802 11.9929 21.198 12.2226 21.3548C13.3107 22.0973 14.6554 22.4686 16 22.4686C17.3446 22.4686 18.6893 22.0973 19.7773 21.3548C20.0071 21.198 20.0692 20.8802 19.916 20.6449C19.7628 20.4097 19.4524 20.3462 19.2226 20.503C18.3025 21.1309 17.1513 21.4449 16 21.4449C15.3173 21.4449 14.6345 21.3345 14 21.1137C13.5646 20.9621 13.1518 20.7585 12.7773 20.503Z" fill="white"></path> </g></svg>',
                whatsapIcon:
                    '<svg width="29px" height="29px" viewBox="-1.5 0 259 259" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M67.6631045,221.823373 L71.8484512,223.916047 C89.2873956,234.379413 108.819013,239.262318 128.350631,239.262318 L128.350631,239.262318 C189.735716,239.262318 239.959876,189.038158 239.959876,127.653073 C239.959876,98.3556467 228.101393,69.7557778 207.17466,48.8290445 C186.247927,27.9023111 158.345616,16.0438289 128.350631,16.0438289 C66.9655467,16.0438289 16.7413867,66.2679889 17.4389445,128.350631 C17.4389445,149.277365 23.7169645,169.50654 34.1803311,186.945485 L36.9705622,191.130831 L25.8096378,232.28674 L67.6631045,221.823373 Z" fill="#00E676"> </path> <path d="M219.033142,37.66812 C195.316178,13.2535978 162.530962,0 129.048189,0 C57.8972956,0 0.697557778,57.8972956 1.39511556,128.350631 C1.39511556,150.67248 7.67313556,172.296771 18.1365022,191.828389 L0,258.096378 L67.6631045,240.657433 C86.4971645,251.1208 107.423898,256.003705 128.350631,256.003705 L128.350631,256.003705 C198.803967,256.003705 256.003705,198.106409 256.003705,127.653073 C256.003705,93.4727423 242.750107,61.3850845 219.033142,37.66812 Z M129.048189,234.379413 L129.048189,234.379413 C110.214129,234.379413 91.380069,229.496509 75.3362401,219.7307 L71.1508934,217.638027 L30.6925422,228.101393 L41.1559089,188.3406 L38.3656778,184.155253 C7.67313556,134.628651 22.3218489,69.05822 72.5460089,38.3656778 C122.770169,7.67313556 187.643042,22.3218489 218.335585,72.5460089 C249.028127,122.770169 234.379413,187.643042 184.155253,218.335585 C168.111425,228.798951 148.579807,234.379413 129.048189,234.379413 Z M190.433273,156.9505 L182.760138,153.462711 C182.760138,153.462711 171.599213,148.579807 164.623636,145.092018 C163.926078,145.092018 163.22852,144.39446 162.530962,144.39446 C160.438289,144.39446 159.043173,145.092018 157.648058,145.789576 L157.648058,145.789576 C157.648058,145.789576 156.9505,146.487133 147.184691,157.648058 C146.487133,159.043173 145.092018,159.740731 143.696902,159.740731 L142.999345,159.740731 C142.301787,159.740731 140.906671,159.043173 140.209113,158.345616 L136.721325,156.9505 L136.721325,156.9505 C129.048189,153.462711 122.072611,149.277365 116.492149,143.696902 C115.097033,142.301787 113.00436,140.906671 111.609245,139.511556 C106.72634,134.628651 101.843436,129.048189 98.3556467,122.770169 L97.658089,121.375053 C96.9605312,120.677496 96.9605312,119.979938 96.2629734,118.584822 C96.2629734,117.189707 96.2629734,115.794591 96.9605312,115.097033 C96.9605312,115.097033 99.7507623,111.609245 101.843436,109.516571 C103.238551,108.121456 103.936109,106.028782 105.331225,104.633667 C106.72634,102.540993 107.423898,99.7507623 106.72634,97.658089 C106.028782,94.1703001 97.658089,75.3362401 95.5654156,71.1508934 C94.1703001,69.05822 92.7751845,68.3606623 90.6825112,67.6631045 L88.5898378,67.6631045 C87.1947223,67.6631045 85.1020489,67.6631045 83.0093756,67.6631045 C81.6142601,67.6631045 80.2191445,68.3606623 78.8240289,68.3606623 L78.1264712,69.05822 C76.7313556,69.7557778 75.3362401,71.1508934 73.9411245,71.8484512 C72.5460089,73.2435667 71.8484512,74.6386823 70.4533356,76.0337978 C65.5704312,82.3118178 62.7802,89.9849534 62.7802,97.658089 L62.7802,97.658089 C62.7802,103.238551 64.1753156,108.819013 66.2679889,113.701918 L66.9655467,115.794591 C73.2435667,129.048189 81.6142601,140.906671 92.7751845,151.370038 L95.5654156,154.160269 C97.658089,156.252942 99.7507623,157.648058 101.145878,159.740731 C115.794591,172.296771 132.535978,181.365022 151.370038,186.247927 C153.462711,186.945485 156.252942,186.945485 158.345616,187.643042 L158.345616,187.643042 C160.438289,187.643042 163.22852,187.643042 165.321193,187.643042 C168.808982,187.643042 172.994329,186.247927 175.78456,184.852811 C177.877233,183.457696 179.272349,183.457696 180.667465,182.06258 L182.06258,180.667465 C183.457696,179.272349 184.852811,178.574791 186.247927,177.179676 C187.643042,175.78456 189.038158,174.389445 189.735716,172.994329 C191.130831,170.204098 191.828389,166.716309 192.525947,163.22852 C192.525947,161.833405 192.525947,159.740731 192.525947,158.345616 C192.525947,158.345616 191.828389,157.648058 190.433273,156.9505 Z" fill="#FFFFFF"> </path> </g> </g></svg>',
                linkedinIcon:
                    '<svg width="35px" height="35px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect x="2" y="2" width="28" height="28" rx="14" fill="#1275B1"></rect> <path d="M12.6186 9.69215C12.6186 10.6267 11.8085 11.3843 10.8093 11.3843C9.81004 11.3843 9 10.6267 9 9.69215C9 8.7576 9.81004 8 10.8093 8C11.8085 8 12.6186 8.7576 12.6186 9.69215Z" fill="white"></path> <path d="M9.24742 12.6281H12.3402V22H9.24742V12.6281Z" fill="white"></path> <path d="M17.3196 12.6281H14.2268V22H17.3196C17.3196 22 17.3196 19.0496 17.3196 17.2049C17.3196 16.0976 17.6977 14.9855 19.2062 14.9855C20.911 14.9855 20.9008 16.4345 20.8928 17.5571C20.8824 19.0244 20.9072 20.5219 20.9072 22H24V17.0537C23.9738 13.8954 23.1508 12.4401 20.4433 12.4401C18.8354 12.4401 17.8387 13.1701 17.3196 13.8305V12.6281Z" fill="white"></path> </g></svg>',
                upArrow:
                    '<svg width="25px" height="25px" viewBox="0 0 48 48" fill="#fff" xmlns="http://www.w3.org/2000/svg"> <rect width="48" height="48" fill="none" fill-opacity="0.01"/> <path d="M16 40H6C4.89543 40 4 39.1046 4 38V10C4 8.89543 4.89543 8 6 8H42C43.1046 8 44 8.89543 44 10V16" stroke="#fff" fill="none" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/> <rect x="24" y="24" width="20" height="16" rx="2" fill="#fff" stroke="none" stroke-width="0" stroke-linejoin="round"/> </svg>',
                castIcon: `<svg fill="#fff" width="25px" height="25px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" stroke="#fff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M 6 6 C 4.897 6 4 6.897 4 8 L 4 12 L 6 12 L 6 8 L 26 8 L 26 24 L 18 24 L 18 26 L 26 26 C 27.103 26 28 25.103 28 24 L 28 8 C 28 6.897 27.103 6 26 6 L 6 6 z M 4 14 L 4 16 C 9.169375 16 13.436179 19.942273 13.949219 24.978516 C 13.983421 25.314265 14 25.655375 14 26 L 16 26 C 16 19.383 10.617 14 4 14 z M 4 18 L 4 20 C 7.309 20 10 22.691 10 26 L 12 26 C 12 21.589 8.411 18 4 18 z M 4 22 L 4 26 L 8 26 C 8 23.791 6.209 22 4 22 z"></path></g></svg>`
            },
            fn: {
                create: function create(element) {
                    return document.createElement(element);
                },
                class: function getClass(element) {
                    return document.querySelector(`.${element}`);
                },
                classAll: function getClassAll(element) {
                    return document.querySelectorAll(`.${element}`);
                },
                id: function getID(element) {
                    return document.getElementById(element);
                },
                addClass: function addClass(element, className) {
                    element.classList.add(className);
                },
                removeClass: function removeClass(element, className) {
                    element.classList.remove(className);
                },
                html: function addHtml(element, html) {
                    element.innerHTML = html;
                },
                toggleClass: function toggleClass(element, className) {
                    if (element.classList.contain(className) == true) {
                        def.fn.removeClass(element, className);
                    } else {
                        def.fn.addClass(element, className);
                    }
                },
                append: function append(parent, child) {
                    parent.appendChild(child);
                },
                remove: function remove(parent, child) {
                    parent.removeChild(child);
                },
                fontColor: function setColor(element, fill = false) {
                    let colors;
                    if (absPlayer.fontColor == "" || absPlayer.fontColor == undefined) {
                        colors = "#fff";
                    } else {
                        colors = absPlayer.fontColor;
                    }
                    fill == false
                        ? (element.style.color = colors)
                        : (element.style.fill = colors);
                },
                hoverColor: function hover(element, fill = false, mute = false) {
                    let hcolors;
                    if (absPlayer.hoverColor == "" || absPlayer.hoverColor == undefined) {
                        hcolors = "red";
                    } else {
                        hcolors = absPlayer.hoverColor;
                    }
                    element.addEventListener("mouseover", () => {
                        fill == false
                            ? (element.style.color = hcolors)
                            : (element.style.fill = hcolors);
                    });
                    element.addEventListener("mouseleave", () => {
                        fill == false
                            ? def.fn.fontColor(element, false)
                            : def.fn.fontColor(element, true);
                        def.fn.activColor();
                    });
                    element.addEventListener("mouleenter", () => {
                        fill == false
                            ? (element.style.color = hcolors)
                            : (element.style.fill = hcolors);
                    });
                },
                activColor: function activColor() {
                    if (isMute == true) {
                        muteSvg.style.fill = absPlayer.hoverColor;
                    } else {
                        def.fn.fontColor(muteSvg, true);
                    }
                    if (isLoud == true) {
                        loudeSvg.style.fill = absPlayer.hoverColor;
                    } else {
                        def.fn.fontColor(loudeSvg, true);
                    }
                },
                css: function css(element, css = {}) {
                    let Scss = "";
                    Object.entries(css).forEach((entry) => {
                        const [key, value] = entry;
                        Scss += `${key}:${value};`;
                    });
                    element.style.cssText = Scss;
                },
                setCss: function setCss(css) {
                    document.head.insertAdjacentHTML("beforeend", `<style>${css}</style>`);
                },
                attribute: function attr(element, attr = {}) {
                    Object.entries(attr).forEach((entry) => {
                        const [key, value] = entry;
                        element.setAttribute(key, value);
                    });
                },
                remove_attribute: function attrRemove(element, attr = {}) {
                    Object.entries(attr).forEach((entry) => {
                        const [key, value] = entry;
                        element.removeAttribute(key);
                    });
                },
                event: function listener(element, event = {}) {
                    Object.entries(event).forEach((entry) => {
                        const [key, value] = entry;
                        element.addEventListener(key, value, false);
                    });
                },
                getAjax: function getAjax(url, data, callback) {
                    $.ajax({
                        url: url,
                        method: "get",
                        data: data,
                        success: callback,
                    });
                },
                postAjax: function postAjax(url, data, callback) {
                    $.ajax({
                        url: url,
                        method: "post",
                        data: data,
                        success: callback,
                    });
                },
                domain: function setDomain() {
                    let dom = window.location.host;
                    if (dom.indexOf(':') != '-1') {
                        let Dm = dom.split(':');
                        return Dm[0];
                    } else {
                        return dom;
                    }

                }
            },
            format: {
                mp3: {
                    codec: 'audio/mpeg',
                    flashCanPlay: true,
                    media: 'audio'
                },
                m4a: {
                    codec: 'audio/mp4; codecs="mp4a.40.2"',
                    flashCanPlay: true,
                    media: 'audio'
                },
                m3u8a: {
                    codec: 'application/vnd.apple.mpegurl; codecs="mp4a.40.2"',
                    flashCanPlay: false,
                    media: 'audio'
                },
                m3ua: {
                    codec: 'audio/mpegurl',
                    flashCanPlay: false,
                    media: 'audio'
                },
                m3u8: {
                    codec: 'audio/x-mpegurl',
                    flashCanPlay: false,
                    media: 'video'
                },
                oga: {
                    codec: 'audio/ogg; codecs="vorbis, opus"',
                    flashCanPlay: false,
                    media: 'audio'
                },
                flac: {
                    codec: 'audio/x-flac',
                    flashCanPlay: false,
                    media: 'audio'
                },
                wav: {
                    codec: 'audio/wav; codecs="1"',
                    flashCanPlay: false,
                    media: 'audio'
                },
                webma: {
                    codec: 'audio/webm; codecs="vorbis"',
                    flashCanPlay: false,
                    media: 'audio'
                },
                fla: {
                    codec: 'audio/x-flv',
                    flashCanPlay: true,
                    media: 'audio'
                },
                rtmpa: {
                    codec: 'audio/rtmp; codecs="rtmp"',
                    flashCanPlay: true,
                    media: 'audio'
                },
                m4v: {
                    codec: 'video/mp4; codecs="avc1.42E01E, mp4a.40.2"',
                    flashCanPlay: true,
                    media: 'video'
                },
                m3u8v: {
                    codec: 'application/vnd.apple.mpegurl; codecs="avc1.42E01E, mp4a.40.2"',
                    flashCanPlay: false,
                    media: 'video'
                },
                m3uv: {
                    codec: 'audio/mpegurl',
                    flashCanPlay: false,
                    media: 'video'
                },
                ogv: {
                    codec: 'video/ogg; codecs="theora, vorbis"',
                    flashCanPlay: false,
                    media: 'video'
                },
                webmv: {
                    codec: 'video/webm; codecs="vorbis, vp8"',
                    flashCanPlay: false,
                    media: 'video'
                },
                flv: {
                    codec: 'video/x-flv',
                    flashCanPlay: true,
                    media: 'video'
                },
                rtmpv: {
                    codec: 'video/rtmp; codecs="rtmp"',
                    flashCanPlay: true,
                    media: 'video'
                }
            }
        };

        var trackStatus,
            subtitles,
            trackCues,
            tracks,
            buttonArray = [],
            button,
            activeCC,
            cc_list,
            seeker,
            cueitem,
            maxDuration,
            currentTime,
            currentDuration,
            snap,
            snapClass,
            apiValue,
            fileExtention,
            isYoutube,
            isVimeo,
            isFacebook,
            hlsFile = Array(),
            hlsItem = "",
            hlsSubtitle = "",
            hlsSubtitleUrl = Array(),
            hlsSubtitleType = Array(),
            hlsAudio = "",
            dashSubtitle = "",
            dashAudio = "",
            isLive = false,
            numberOfButtons = 0,
            allTrackLoaded = false,
            hls = undefined,
            vmPlayer = undefined,
            vmActive = false,
            vmDuration = undefined,
            vmCurrentTime = undefined,
            isSoundOpen = false,
            isControleopn = false,
            isMute = false,
            isVast = false,
            isCast = false,
            isCastEnable = false,
            isMidroll = false,
            mouseMove = false,
            isPlayFalse = false,
            encrypt = absPlayer.encrypt,
            player,
            xplayer = [],
            playername,
            logoArea,
            playlist = [],
            playIndex,
            qualityIndex,
            speedIndex,
            m3uIndex,
            isLoop,
            activeQuality,
            activeSubtitle,
            activeAudio,
            activePlayback,
            activeLoop,
            youtubePlayer = null,
            dashPlayer,
            isPlaying = false,
            isVideoEnded = false,
            ytEvent = null,
            isMenu = true,
            player360,
            video360,
            w360, h360,
            hoverIndex = 999999999,
            isApi = true,
            normalIndex = 9999999,
            closeCounterNumber = 0;

        controlsBG = 'rgba(0,0,0,0.3)',
            ytQualityText = ["highres", "hd2160", "hd1440", "hd1080", "hd720", "large", "medium", "small", "tiny", "auto"],
            ytSpeed = ['0.25', '0.5', '0.75', '1', '1.25', '1.5', '1.75', '2'],
            ytQualityItem = '',
            currentEvent = {
                isPlaying: '',
                duration: '',
                currentTime: '',
                quality: [],
                qualityLabel: '',
                subtitle: [],
                audios: [],
                end: '',
                volume: '',
                mute: '',
                playback: '',
                mode: '',
                info: undefined,
                buffer: ''
            };

        let textCast = navigator.appVersion;
        let positionCast = textCast.indexOf("Chrome");
        if (positionCast > 0) {
            isCast = true;
        }

        thisID = def.fn.id(this[0].getAttribute('id'));
        def.fn.css(thisID, {
            'aspect-ratio': '16/9',
            background: 'rgba(0,0,0,0.8)',
            position: 'relative',
            width: '100%'
        });

        player = def.fn.create('div');
        def.fn.css(player, {
            background: "rgba(0,0,0,1)",
            position: "absolute",
            top: 0,
            left: 0,
            width: '100%',
            height: '100%',
            display: "flex",
            "flex-direction": "column",
            overflow: 'hidden'
        });
        def.fn.attribute(player, {
            'oncontextmenu': "return true",
            'id': 'absPlayerPlayer'
        });

        logoArea = def.fn.create('div');
        def.fn.attribute(logoArea, {
            oncontextmenu: 'return false'
        });
        def.fn.append(player, logoArea);

        logo = def.fn.create('img');
        def.fn.css(logo, {
            position: "absolute",
            width: "100%",
            height: "100%",
            display: "flex",
            'align-items': "center",
            'justify-content': "center",
            'border-radius': "50%",
            'z-index': 99999999,
            overflow: "hidden"
        });
        def.fn.attribute(logo, {
            oncontextmenu: "return false",
            src: absPlayer.logo[0]
        });
        absPlayer.logo != '' ? def.fn.append(logoArea, logo) : ''

        controls = def.fn.create('div');
        def.fn.css(controls, {
            background: controlsBG,
            width: "100%",
            height: "50px",
            position: "absolute",
            left: 0,
            bottom: 0,
            display: "flex",
            'align-items': "center",
            'flex-direction': "column",
            'z-index': 9999999,
            transition: '0.5s'
        });
        def.fn.append(player, controls);

        topControls = def.fn.create('div');
        def.fn.css(topControls, {
            background: '#000',
            width: "100%",
            height: "0px",
            position: "absolute",
            left: 0,
            top: 0,
            display: "none",
            'align-items': "center",
            'flex-direction': "column",
            'z-index': 99999,
            transition: '0.5s'
        });
        def.fn.append(player, topControls);
        def.fn.attribute(topControls, {
            oncontextmenu: 'return false'
        });

        bottomControls = def.fn.create('div');
        def.fn.css(bottomControls, {
            background: '#000',
            width: "100%",
            height: "0px",
            position: "absolute",
            left: 0,
            bottom: 0,
            display: "none",
            'align-items': "center",
            'flex-direction': "column",
            'z-index': 99999,
            transition: '0.5s'
        });
        def.fn.append(player, bottomControls);
        def.fn.attribute(bottomControls, {
            oncontextmenu: 'return false'
        });


        progress = def.fn.create('div');
        def.fn.css(progress, {
            width: "98%",
            height: "3px",
            position: "absolute",
            bottom: "50px",
            background: "#f9f9f9",
            left: '1%',
            right: '1%',
            "z-index": 999999,
            'border-radius': '4px',
            cursor: "pointer",
            overflow: 'hidden',
            transition: "all 0.3s"
        });
        def.fn.append(player, progress);
        def.fn.attribute(progress, {
            oncontextmenu: 'return false'
        });

        progressBuffer = def.fn.create('div');
        def.fn.css(progressBuffer, {
            width: '100%',
            height: '100%',
            background: 'darkgray',
            position: 'absolute',
            top: 0,
            left: 0,
            cursor: 'pointer',
            'z-index': -2
        });
        def.fn.append(progress, progressBuffer);

        progressTimeline = def.fn.create('div');
        def.fn.css(progressTimeline, {
            position: 'absolute',
            width: 0,
            height: '100%',
            top: 0,
            left: 0,
            background: 'red',
            cursor: 'pointer'
        });
        def.fn.append(progress, progressTimeline);

        progressTooltip = def.fn.create('div');
        def.fn.css(progressTooltip, {
            width: 'auto',
            height: '18px',
            background: '#fff',
            position: 'absolute',
            bottom: '60px',
            left: 0,
            cursor: 'pointer',
            'z-index': -2,
            color: '#000',
            'border-radius': '8px',
            padding: '4px 8px',
            display: 'flex',
            'font-size': '12px',
            'align-items': 'center',
            'justify-content': 'center'
        });
        def.fn.append(player, progressTooltip);

        durationArea = def.fn.create('div');
        def.fn.css(durationArea, {
            display: 'flex',
            width: '98%',
            position: 'absolute',
            left: '1%',
            right: '1%',
            bottom: '52px',
            'z-index': 99999,
            'align-items': 'center',
            'justify-content': 'space-between'
        });
        def.fn.append(player, durationArea);
        def.fn.attribute(durationArea, {
            oncontextmenu: 'return false'
        });

        durationCurrent = def.fn.create('p');
        def.fn.css(durationCurrent, {
            color: '#fff',
            'font-size': '12px'
        });
        def.fn.html(durationCurrent, '00:00');
        def.fn.append(durationArea, durationCurrent);

        durationText = def.fn.create('p');
        def.fn.css(durationText, {
            color: '#fff',
            'font-size': '12px'
        });
        def.fn.html(durationText, '00:00');
        def.fn.append(durationArea, durationText);

        allControlls = def.fn.create('div');
        def.fn.css(allControlls, {
            width: "98%",
            height: "100%",
            display: "flex",
            'align-items': 'center',
            'justify-content': 'space-between',
        });
        def.fn.append(controls, allControlls);
        def.fn.attribute(allControlls, {
            oncontextmenu: 'return false'
        });

        leftControlls = def.fn.create('div');
        def.fn.css(leftControlls, {
            display: "flex",
            gap: '10px',
            'align-items': 'center',
            'justify-content': 'flex-start'
        });
        def.fn.append(allControlls, leftControlls);

        playPauseControll = def.fn.create('button');
        def.fn.css(playPauseControll, {
            background: 'none',
            cursor: 'pointer',
            border: 'none',
            outline: 'none',
            'font-size': '20px',
            color: "#fff",
            padding: '3px'
        });
        def.fn.html(playPauseControll, def.icons.playBtn);
        def.fn.append(leftControlls, playPauseControll);
        playPauseControll.addEventListener('click', () => {
            togglePlayPause();
        })

        volumeContainer = def.fn.create('div');
        def.fn.css(volumeContainer, {
            width: 'auto',
            display: 'flex',
            'align-items': 'center',
            margin: '0px 4px'
        });
        def.fn.append(leftControlls, volumeContainer);

        volumeControll = def.fn.create('button');
        def.fn.css(volumeControll, {
            background: 'none',
            cursor: 'pointer',
            border: 'none',
            outline: 'none',
            'font-size': '20px',
            color: "#fff",
            padding: '3px'
        });
        def.fn.html(volumeControll, def.icons.soundLower);
        def.fn.append(volumeContainer, volumeControll);

        volumeSliderArea = def.fn.create('div');
        def.fn.css(volumeSliderArea, {
            width: '0px',
            height: '5px',
            background: 'gray',
            cursor: 'pointer',
            transition: '0.5s'
        });
        def.fn.append(volumeContainer, volumeSliderArea);

        volumeSlider = def.fn.create('div');
        def.fn.css(volumeSlider, {
            width: '0px',
            height: '5px',
            background: 'red',
            cursor: 'pointer',
            transition: '0.5s'
        });
        def.fn.attribute(volumeSlider, {
            max: 100,
            min: 0,
            current: 20
        });
        def.fn.append(volumeSliderArea, volumeSlider);
        this.append(player);

        castControl = def.fn.create('button');
        def.fn.css(castControl, {
            background: 'none',
            cursor: 'pointer',
            border: 'none',
            outline: 'none',
            'font-size': '20px',
            color: "#fff",
            padding: '3px',
            display: 'none'
        });
        def.fn.html(castControl, def.icons.castIcon);
        def.fn.append(leftControlls, castControl);

        backwardControll = def.fn.create('button');
        def.fn.css(backwardControll, {
            background: 'none',
            cursor: 'pointer',
            border: 'none',
            outline: 'none',
            'font-size': '20px',
            color: "#fff",
            padding: '3px',
        });
        def.fn.html(backwardControll, def.icons.moveBackward);
        absPlayer.backward == true ? def.fn.append(leftControlls, backwardControll) : '';

        forwardControll = def.fn.create('button');
        def.fn.css(forwardControll, {
            background: 'none',
            cursor: 'pointer',
            border: 'none',
            outline: 'none',
            'font-size': '20px',
            color: "#fff",
            padding: '3px',
        });
        def.fn.html(forwardControll, def.icons.moveForward);
        absPlayer.forward == true ? def.fn.append(leftControlls, forwardControll) : '';

        rightControlls = def.fn.create('div');
        def.fn.css(rightControlls, {
            display: 'flex',
            gap: '10px',
            'align-items': 'center'
        });
        def.fn.append(allControlls, rightControlls);

        if(absPlayer.share){
            shareControll = def.fn.create('button');
            def.fn.css(shareControll, {
                background: 'none',
                cursor: 'pointer',
                border: 'none',
                outline: 'none',
                'font-size': '20px',
                color: "#fff",
                padding: '3px'
            });
            def.fn.html(shareControll, def.icons.shareIcon);
            def.fn.append(rightControlls, shareControll); 
            def.fn.event(shareControll,{
                'click': toggleShare
            });
        }

        shareArea = def.fn.create('div');
        def.fn.css(shareArea,{
            position: 'absolute',
            width: '100%',
            height: '100%',
            background: 'rgba(0,0,0,0.4)',
            'z-index': 999999,
            display: 'none',
            'align-items': 'center',
            'justify-content':'center',
            margin: '0px',
        });
        def.fn.append(player, shareArea);
        def.fn.attribute(shareArea, {
            oncontextmenu: 'return false'
        });

        settingsControll = def.fn.create('button');
        def.fn.css(settingsControll, {
            background: 'none',
            cursor: 'pointer',
            border: 'none',
            outline: 'none',
            'font-size': '20px',
            color: "#fff",
            padding: '3px'
        });
        def.fn.html(settingsControll, def.icons.settings);
        def.fn.append(rightControlls, settingsControll);

        settingsOptions = def.fn.create('div');
        def.fn.css(settingsOptions, {
            width: '160px',
            color: '#fff',
            position: 'absolute',
            bottom: '60px',
            right: '12px',
            padding: '2px',
            'border-radius': '4px',
            display: 'flex',
            'align-items': 'center',
            'flex-direction': 'row',
            transition: '0.5s',
            'z-index': 99999999
        });
        def.fn.append(player, settingsOptions);
        def.fn.attribute(settingsOptions, {
            oncontextmenu: 'return false'
        });

        settingsOptionBefore = def.fn.create('div');
        def.fn.css(settingsOptionBefore, {
            width: '100%',
            height: 'auto',
            background: 'rgba(0,0,0,0.3)',
            color: '#fff',
            position: 'absolute',
            padding: '2px',
            bottom: 0,
            left: 0,
            'border-radius': '4px',
            display: 'none',
            'align-items': 'center',
            'flex-direction': 'column',
            transition: '0.5s'
        });
        def.fn.append(settingsOptions, settingsOptionBefore);

        itemQuality = def.fn.create('div');
        def.fn.css(itemQuality, {
            width: '100%',
            height: '27px',
            color: '#fff',
            display: 'flex',
            'align-items': 'center',
            'justify-content': 'space-between',
            cursor: 'pointer',
            'font-size': '12px',
        });
        def.fn.html(itemQuality, `<p style='padding:0 !important;font-size:12px;font-family:sans-serif;margin:0 !important;'>Quality</p><p style='padding:0 !important;font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p>`);
        def.fn.append(settingsOptionBefore, itemQuality);

        itemPlayback = def.fn.create('div');
        def.fn.css(itemPlayback, {
            width: '100%',
            height: '27px',
            color: '#fff',
            display: 'flex',
            'align-items': 'center',
            'justify-content': 'space-between',
            cursor: 'pointer',
            'font-size': '12px',
        });
        def.fn.html(itemPlayback, `<p style='padding:0 !important;font-size:12px;font-family:sans-serif;margin:0 !important;'>Playback</p><p style='padding:0 !important;font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p>`);
        def.fn.append(settingsOptionBefore, itemPlayback);

        itemSubtitle = def.fn.create('div');
        def.fn.css(itemSubtitle, {
            width: '100%',
            height: '27px',
            color: '#fff',
            display: 'flex',
            'align-items': 'center',
            'justify-content': 'space-between',
            cursor: 'pointer',
            'font-size': '12px',
        });
        def.fn.html(itemSubtitle, `<p style='padding:0 !important;font-size:12px;font-family:sans-serif;margin:0 !important;'>Subtitle</p><p style='padding:0 !important;font-size:12px;font-family:sans-serif;margin:0 !important'>${def.icons.rightArrow}</p>`);
        def.fn.append(settingsOptionBefore, itemSubtitle);

        itemAudio = def.fn.create('div');
        def.fn.css(itemAudio, {
            width: '100%',
            height: '27px',
            color: '#fff',
            display: 'flex',
            'align-items': 'center',
            'justify-content': 'space-between',
            cursor: 'pointer',
            'font-size': '12px',
        });
        def.fn.html(itemAudio, `<p style='padding:0 !important;font-size:12px;font-family:sans-serif;margin:0 !important;'>Audio</p><p style='padding:0 !important;font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p>`);
        def.fn.append(settingsOptionBefore, itemAudio);

        itemLoop = def.fn.create('div');
        def.fn.css(itemLoop, {
            width: '100%',
            height: '27px',
            color: '#fff',
            display: 'flex',
            'align-items': 'center',
            'justify-content': 'space-between',
            cursor: 'pointer',
            'font-size': '12px'
        });
        def.fn.html(itemLoop, `<p style='padding:0 !important;font-size:12px;font-family:sans-serif;margin:0 !important;'>Loop</p><p style='padding:0 !important;font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p>`);
        def.fn.append(settingsOptionBefore, itemLoop);

        settingsBack = def.fn.create('div');
        def.fn.css(settingsBack, {
            width: '100%',
            height: '27px',
            color: '#fff',
            display: 'flex',
            'align-items': 'center',
            'justify-content': 'space-between',
            cursor: 'pointer',
            'font-size': '12px'
        });
        def.fn.html(settingsBack, `<p style='padding:0 !important;font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.backBtn}</p><p style='padding:0 !important;font-size:12px;font-family:sans-serif;margin:0 !important;'>Back</p>`);

        settingsOptionAfter = def.fn.create('div');
        def.fn.css(settingsOptionAfter, {
            width: '100%',
            height: 'auto',
            background: 'rgba(0,0,0,0.8)',
            color: '#fff',
            position: 'absolute',
            bottom: 0,
            left: 0,
            'border-radius': '4px',
            display: 'none',
            'align-items': 'center',
            'flex-direction': 'column',
            transition: '0.5s'
        });

        def.fn.attribute(settingsOptionAfter, {
            oncontextmenu: 'return false',
            onselectstart: 'return false'
        })
        def.fn.append(settingsOptions, settingsOptionAfter);



        settingsOptionsItem = def.fn.create('div');
        def.fn.css(settingsOptionsItem, {
            width: '100%',
            height: 'auto',
            background: "rgba(0,0,0,0,3)"
        });

        playlistContainerBox = def.fn.create('div');
        def.fn.css(playlistContainerBox, {
            background: 'none',
            border: 'none',
            outline: 'none',
            'font-size': '20px',
            color: "#fff",
            width: '170px',
            height: 'calc(100% - 60px)',
            position: 'absolute',
            top: 0,
            right: 0,
            display: 'flex',
            transition: 'all 0.5s each',
            'overflow': 'hidden',
            'max-height': 'calc(100% - 60px)',
            'align-items': 'center',
            'justify-content': 'flex-start',
            'flex-direction': 'column'
        });
        def.fn.attribute(playlistContainerBox, {
            oncontextmenu: 'return false',
            onselectstart: 'return false'
        })
        def.fn.append(player, playlistContainerBox);

        playlistContainer = def.fn.create('div');
        def.fn.css(playlistContainer, {
            background: 'rgba(0,0,0,0.41)',
            border: 'none',
            outline: 'none',
            'font-size': '20px',
            color: "#fff",
            width: '100%',
            height: '100%',
            position: 'absolute',
            top: 0,
            right: 0,
            display: 'flex',
            transition: 'all 0.5s',
            'margin-right': '-280px',
            'max-height': '100%',
            'overflow-y': 'auto',
            'overflow-x': 'hidden',
            'z-index': 999999,
            'align-items': 'center',
            'justify-content': 'flex-start',
            'flex-direction': 'column'
        });
        def.fn.append(playlistContainerBox, playlistContainer);

        playlistController = def.fn.create('button');
        def.fn.css(playlistController, {
            background: 'none',
            cursor: 'pointer',
            border: 'none',
            outline: 'none',
            display: 'none',
            'font-size': '20px',
            color: "#fff",
            padding: '3px'
        });
        def.fn.html(playlistController, def.icons.playlist);
        def.fn.append(rightControlls, playlistController);

        screenController = def.fn.create('button');
        def.fn.css(screenController, {
            background: 'none',
            cursor: 'pointer',
            border: 'none',
            outline: 'none',
            'font-size': '20px',
            color: "#fff",
            padding: '3px'
        });
        def.fn.html(screenController, def.icons.faullScreenEnter);
        def.fn.append(rightControlls, screenController);
        screenController.addEventListener('click', () => {
            toggleFullscreen();
        })

        let errorMsg = def.fn.create('h3');
        def.fn.css(errorMsg, {
            'text-align': 'center',
            position: 'absolute',
            'z-index': 99999999,
            left: '50%',
            top: '50%',
            'transform': 'translate(-50%,-50%)',
            color: 'red'
        });
        def.fn.append(player, errorMsg);

        settingsBack = def.fn.create('div');
        def.fn.css(settingsBack, {
            width: '90%',
            height: '20px',
            color: '#fff',
            display: 'flex',
            'align-items': 'center',
            'justify-content': 'space-between',
            cursor: 'pointer',
            'font-size': '12px',
            margin: '5px 4px'
        });
        def.fn.html(settingsBack, '<p style="font-family:sans-serif;margin:0 !important;">Back</p><p style="font-family:sans-serif;margin:0 !important;">' + def.icons.backBtn + '</p>');

        video = def.fn.create('video');
        def.fn.css(video, {
            width: '100%',
            height: '100%',
            position: 'absolute'
        });
        def.fn.attribute(video, {
            preload: 'metadata',
            tabindex: -1,
            disableremoteplayback: 'true',
            'webkit-playsinline': 'true',
            playsinline: 'true',
            controlsList: 'no download',
            oncontextmenu: 'return false'
        });
        def.fn.append(player, video);

        ytPlayer = def.fn.create('div');
        def.fn.attribute(ytPlayer, {
            id: 'ytIframe'
        });
        def.fn.css(ytPlayer, {
            width: '100%',
            height: '100%',
            position: 'absolute',
            display: 'none',
            'z-index': 998
        });
        def.fn.append(player, ytPlayer);

        player360 = def.fn.create('div');
        def.fn.css(player360, {
            width: '100%',
            height: '100%',
            position: 'absolute',
            display: 'flex',
            background: 'transparent',
            cursor: 'pointer',
            'z-index': 9999
        });
        def.fn.append(player, player360);

        youtubeClick = def.fn.create('div');
        def.fn.css(youtubeClick, {
            width: '100%',
            height: '100%',
            position: 'absolute',
            display: 'flex',
            background: 'transparent',
            'z-index': 99999
        });
        def.fn.append(player, youtubeClick);
        youtubeClick.addEventListener('click', () => {
            isApi ? togglePlayPause() : false;
            isControleopn = false;
            settingsOptionAfter.style.display = "none";
            settingsOptionBefore.style.display = "none";
        })

        vimeoPlayer = def.fn.create('div');
        def.fn.attribute(vimeoPlayer, {
            id: 'vmFrame'
        });
        def.fn.css(vimeoPlayer, {
            width: '100%',
            height: '100%',
            position: 'absolute',
            display: 'none',
            overflow: 'hidden'
        });
        def.fn.append(player, vimeoPlayer);

        vimeoClick = def.fn.create('div');
        def.fn.css(vimeoClick, {
            width: '100%',
            height: 'calc(100% - 60px)',
            position: 'absolute',
            display: 'none',
            background: 'transparent',
            'z-index': 998
        });
        def.fn.append(player, vimeoClick);
        def.fn.attribute(vimeoClick, {
            oncontextmenu: 'return false'
        });
        vimeoClick.addEventListener('click', () => {
            isApi ? togglePlayPause() : false;
        })

        adsContainer = def.fn.create('div');
        def.fn.attribute(adsContainer, {
            id: 'adsContainer'
        });
        def.fn.css(adsContainer, {
            width: '100%',
            height: '100%',
            position: 'absolute',
            display: 'none',
            background: '#000',
            'z-index': 9999999
        });
        def.fn.append(player, adsContainer);
        def.fn.attribute(adsContainer, {
            oncontextmenu: 'return false'
        });

        adsContent = def.fn.create('div');
        def.fn.attribute(adsContent, {
            id: 'adsContent'
        });
        def.fn.css(adsContent, {
            width: '100%',
            height: '100%',
            position: 'absolute',
            display: 'none'
        });
        def.fn.append(adsContainer, adsContent);
        adsContentVideo = def.fn.create('video');
        def.fn.css(adsContentVideo, {
            width: '100%',
            height: '100%',
            position: 'absolute',
            display: 'none',
            'z-index': 99999999
        });
        def.fn.append(player, adsContentVideo);
        def.fn.attribute(adsContentVideo, {
            preload: 'metadata',
            tabindex: -1,
            disableremoteplayback: 'true',
            'webkit-playsinline': 'true',
            playsinline: 'true',
            controlsList: 'no download',
            oncontextmenu: 'return false',
            muted: 1,
            autoplay: 1
        });

        adsTimer = def.fn.create('div');
        def.fn.css(adsTimer, {
            position: 'absolute',
            right: 0,
            bottom: '40px',
            width: 'auto',
            height: '35px',
            background: 'rgba(0,0,0,0.9)',
            padding: '4px 6px',
            color: '#fff',
            display: 'none',
            'z-index': 9999999999,
            'font-size': '12px',
            'font-family': 'sans-serif',
            'align-items': 'center',
            'justify-content': 'center',
        });
        def.fn.append(player, adsTimer);
        def.fn.attribute(adsTimer, {
            oncontextmenu: 'return false'
        });

        adsHandler = def.fn.create('svg');
        def.fn.css(adsHandler, {
            width: '50px',
            height: '50px',
            position: 'absolute',
            display: 'none',
            color: '#fff',
            cursor: 'pointer',
            'z-index': 999999,
            'font-size': '50px',
            'text-align': 'center',
            'align-items':'center',
            'justify-content': 'center',
            left: '50%',
            top: '50%',
            transform: "translate(-50%,-50%)",
        });
        def.fn.html(adsHandler, def.icons.playBtn);
        def.fn.append(player, adsHandler);

        loader = def.fn.create('svg');
        def.fn.attribute(adsContent, {
            id: 'loader'
        });
        def.fn.css(loader, {
            width: '100px',
            height: '100px',
            position: 'absolute',
            display: 'none',
            left: '50%',
            top: '50%',
            transform: 'translate(-50%,-50%)'
        });
        def.fn.html(loader, def.icons.buffuerLoader);
        def.fn.append(player, loader);

        progress.addEventListener("click", (e) => {
            toggleScrubbing(e);
        });

        progress.addEventListener('mouseover', (e) => {
            scrubibing(e);
        });

        progress.addEventListener('mousemove', (e) => {
            scrubibing(e);
        });

        progress.addEventListener('touchover', (e) => {
            scrubibing(e);
        })

        progress.addEventListener('mouseleave', () => {
            progressTooltip.style.zIndex = -1;
            progress.style.height = "3px";
        });

        progress.addEventListener('touchend', () => {
            progressTooltip.style.zIndex = -1;
            progress.style.height = "3px";
        });



        def.fn.addClass(youtubeClick, 'pr_right_option');
        def.fn.addClass(youtubeClick, 'pr_option');
        rightOptions('.pr_right_option', player);

        let handle = absPlayer.logo[1] ?? 'top';
        let needHandle = absPlayer.logo[3] ?? 'right';

        if (handle == 'top' && needHandle == 'left') {
            def.fn.css(logoArea, {
                position: "absolute",
                width: '70px',
                height: '65px',
                top: (absPlayer.logo[2] ?? 10) + "px",
                left: (absPlayer.logo[4] ?? 10) + "px",
                "border-radius": "50%",
                overflow: "hidden"
            });
        } else if (handle == 'bottom' && needHandle == 'right') {
            def.fn.css(logoArea, {
                position: "absolute",
                width: '70px',
                height: '65px',
                bottom: (absPlayer.logo[2] ?? 10) + "px",
                right: (absPlayer.logo[4] ?? 10) + "px",
                "border-radius": "50%",
                overflow: "hidden"
            });
        } else if (handle == 'bottom' && needHandle == 'left') {
            def.fn.css(logoArea, {
                position: "absolute",
                width: '70px',
                height: '65px',
                bottom: (absPlayer.logo[2] ?? 10) + "px",
                left: (absPlayer.logo[4] ?? 10) + "px",
                "border-radius": "50%",
                overflow: "hidden"
            });
        } else if (handle == 'top' && needHandle == 'right') {
            def.fn.css(logoArea, {
                position: "absolute",
                width: '70px',
                height: '65px',
                top: (absPlayer.logo[2] ?? 10) + "px",
                right: (absPlayer.logo[4] ?? 10) + "px",
                "border-radius": "50%",
                overflow: "hidden"
            });
        }


        volumeContainer.addEventListener('mouseenter', () => {
            if (volumeSlider != undefined) {
                def.fn.css(volumeSlider, {
                    width: volumeSlider.getAttribute('current') + 'px',
                    height: '5px',
                    background: 'red',
                    cursor: 'pointer',
                    transition: '0.5s'
                });

                def.fn.css(volumeSliderArea, {
                    width: '100px',
                    height: '5px',
                    background: 'gray',
                    cursor: 'pointer',
                    transition: '0.5s'
                });
            }
        });
        volumeContainer.addEventListener('touchstart', () => {
            if (isSoundOpen == false) {
                def.fn.css(volumeSlider, {
                    width: volumeSlider.getAttribute('current') + 'px',
                    height: '5px',
                    background: 'red',
                    cursor: 'pointer',
                    transition: '0.5s'
                });

                def.fn.css(volumeSliderArea, {
                    width: '100px',
                    height: '5px',
                    background: 'gray',
                    cursor: 'pointer',
                    transition: '0.5s'
                });
            }

            if (isSoundOpen == true) {
                def.fn.css(volumeSlider, {
                    width: '0px',
                    height: '5px',
                    background: 'red',
                    cursor: 'pointer',
                    transition: '0.5s'
                });

                def.fn.css(volumeSliderArea, {
                    width: '0px',
                    height: '5px',
                    background: 'gray',
                    cursor: 'pointer',
                    transition: '0.5s'
                });
            }
            if (isSoundOpen == false) {
                isSoundOpen = true;
            } else {
                isSoundOpen = false;
            }
            touchvolumeHide();
        });

        volumeContainer.addEventListener('mouseleave', () => {
            if (volumeSlider != undefined) {
                def.fn.css(volumeSlider, {
                    width: '0px',
                    height: '5px',
                    background: 'red',
                    cursor: 'pointer',
                    transition: '0.5s'
                });

                def.fn.css(volumeSliderArea, {
                    width: '0px',
                    height: '5px',
                    background: 'gray',
                    cursor: 'pointer',
                    transition: '0.5s'
                });
            }
        });

        volumeControll.addEventListener('click', () => {
            toggleMute();
        })

        volumeSliderArea.addEventListener("click", (e) => {
            const rect = e.target.getBoundingClientRect();
            const soundWidth = Math.min(Math.max(0, e.x - rect.x), rect.width);
            volumeSlider.setAttribute("current", soundWidth);
            volumeSlider.style.cssText = `width: ${volumeSlider.getAttribute(
                "current"
            )}px;height:5px;background:red;cursor:pointer;transition:0.5s`;

            if (Math.ceil(soundWidth) > 0 && Math.ceil(soundWidth) < 50) {
                volumeControll.innerHTML = def.icons.soundLower;
            } else if (
                Math.ceil(soundWidth) > 49 &&
                Math.ceil(soundWidth) <= 100
            ) {
                volumeControll.innerHTML = def.icons.soundHigher;
            }
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                if (absPlayer.v360) {
                    video360.volume = soundWidth / 100;
                } else {
                    video.volume = soundWidth / 100;
                }
            } else if (isYoutube == 'yTb') {
                youtubePlayer.setVolume((soundWidth));
            } else if (playername == 'vimeo') {
                vmPlayer.setVolume(soundWidth / 100);
            }
            if (isMute) {
                toggleMute();
            }
            localStorage.setItem('pr_active_sound', soundWidth);
        });

        backwardControll.addEventListener('click', () => {
            seekBackward();
        })

        forwardControll.addEventListener('click', () => {
            seekForward();
        })

        settingsControll.addEventListener('click', () => {
            if (isControleopn == false) {
                isControleopn = true;
                settingsOptionAfter.style.display = "none";
                settingsOptionBefore.style.display = "flex";
            } else {
                isControleopn = false;
                settingsOptionAfter.style.display = "none";
                settingsOptionBefore.style.display = "none";
            }
        });

        settingsBack.addEventListener("click", () => {
            settingsOptionBefore.style.display = "flex";
            settingsOptionAfter.style.display = "none";
        });

        playlistController.addEventListener('click', () => {
            togglePlaylist();
        })

        itemPlayback.addEventListener("click", () => {
            settingsOptionBefore.style.display = "none";
            settingsOptionAfter.style.display = "flex";

            let playbackSpeed = "";
            if (absPlayer.playback != "" && Array.isArray(absPlayer.playback)) {
                for (let p = 0; p < absPlayer.playback.length; p++) {
                    playbackSpeed += `<div class="pr_playback ${activePlayback == p ? 'pr_active' : ''}" play-rate='${absPlayer.playback[p]}' index='${p}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${absPlayer.playback[p]}x</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p></div>`;
                }
            } else {
                const playbacks = [0.25, 0.5, 0.75, 1, 1.25, 1.5, 1.75, 2];
                for (let p = 0; p < playbacks.length; p++) {
                    playbackSpeed += `<div class="pr_playback ${activePlayback == p ? 'pr_active' : ''}" play-rate='${playbacks[p]}' index='${p}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${playbacks[p]}x</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${buttons.rightArrow}</p></div>`;
                }
            }

            def.fn.html(settingsOptionAfter, playbackSpeed);
            def.fn.append(settingsOptionAfter, settingsBack);
            const allPlaybacks = document.querySelectorAll(".pr_playback");
            allPlaybacks.forEach((item, index) => {
                setcallBack(item, togglePlayback);
            })
        });

        itemLoop.addEventListener("click", () => {
            settingsOptionBefore.style.display = "none";
            settingsOptionAfter.style.display = "flex";
            let loopItem = "";
            const loops = ['Yes', 'No'];
            for (let l = 0; l < loops.length; l++) {
                loopItem += `<div class="pr_loop ${activeLoop == l ? 'pr_active' : ''}" data-id='${l
                    }' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${loops[l]}</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow
                    }</p></div>`;
            }
            def.fn.html(settingsOptionAfter, loopItem);
            def.fn.append(settingsOptionAfter, settingsBack);

            const allLoops = document.querySelectorAll(".pr_loop");
            allLoops.forEach((item, index) => {
                setcallBack(item, togglePlaybackLoop);
            })
        });

        if (player.offsetHeight < 400) {
            def.fn.css(settingsOptionAfter, {
                width: '100%',
                height: 'auto',
                background: 'rgba(0,0,0,0.3)',
                color: '#fff',
                position: 'absolute',
                bottom: 0,
                left: 0,
                'border-radius': '4px',
                display: 'none',
                'align-items': 'center',
                'flex-direction': 'column',
                'max-height': '150px',
                'overflow-y': 'auto',
                'overflow-x': 'hidden',
                '-ms-overflow-style': 'none',
                'scrollbar-width': 'none',
                '@::-webkit-scrollbar': 'none',
                transition: '0.5s'
            });
        }

        const settingItems = [itemPlayback, itemAudio, itemLoop, itemQuality, itemSubtitle, settingsBack, player360];

        settingItems.forEach((item, index) => {
            item.addEventListener('mouseenter', () => {
                item.style.background = "rgba(0,0,0,0.6)";
                item.style.color = "orange";
                item.style.padding = '3px 2px';
                item.style.borderRadius = '4px';
                item.style.paddingLeft = '4px';
                item.style.transition = '0.1s'
            })
            item.addEventListener('mouseleave', () => {
                item.style.background = "none";
                item.style.padding = '0px';
                item.style.color = "#fff";
                item.style.borderRadius = '0px';
                item.style.paddingLeft = '0px';
                item.style.transition = '0.1s'
            })
        });

        const controlsItem = [player, video, controls, durationArea, youtubeClick, vimeoClick, progressTimeline, playlistContainerBox];
        controlsItem.forEach((item, index) => {
            if (item != undefined && item != null) {
                item.addEventListener('mouseenter', () => { openControls() });
                item.addEventListener('mouseover', () => { isMouseMove() });
                item.addEventListener('mousemove', () => { isMouseMove() });
                item.addEventListener('touchstart', () => { openControls() });

                item.addEventListener('mouseleave', () => { closeCounterNumber = 0; });
                item.addEventListener('touchend', () => { closeCounterNumber = 0; });
            }
        });

        const fullScreenControllers = [youtubeClick, video, video360, vimeoPlayer];
        fullScreenControllers.forEach((item) => {
            if (item != undefined && item != null) {
                item.addEventListener('dblclick', () => {
                    toggleFullscreen();
                })
            }
        })

        if (absPlayer.poster != '' | absPlayer.poster != undefined) {
            addPoster();
        }

        let css = `.pr_active{color : orange !important;background:rgba(0,0,0,0.41) !important;border-radius:3px !important;}.pr_option{width:100%;height:100%;position:absolute;top:0;z-index:1;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.5);font-size:2vw}.contextMenu{--menu-border:rgba(255,255,255,.08);--menu-bg:linear-gradient(45deg,rgba(10,20,28,.2) 0%,rgba(10,20,28,.7) 100%);--item-border:rgba(255,255,255,.1);--item-color:#fff;--item-bg-hover:rgba(255,255,255,.1);height:0;overflow:hidden;background:var(--menu-bg);-webkit-backdrop-filter:blur(5px);backdrop-filter:blur(5px);position:fixed;top:var(--top);left:var(--left);-webkit-animation:menuAnimation 0.4s 0s both;animation:menuAnimation 0.4s 0s both;transform-origin:left;list-style:none;margin:4px;padding:0;display:flex;flex-direction:column;z-index:999999999;box-shadow:0 0 0 1px var(--menu-border),0 2px 2px rgba(0,0,0,.03),0 4px 4px rgba(0,0,0,.04),0 10px 8px rgba(0,0,0,.05),0 12px 12px rgba(0,0,0,.06),0 30px 30px rgba(0,0,0,.07),0 70px 65px rgba(0,0,0,.09)}.contextMenu-item{padding:4px}.contextMenu-item[data-divider="top"]{border-top:1px solid}.contextMenu-item[data-divider="bottom"]{border-bottom:1px solid}.contextMenu-item[data-divider="top-bottom"]{border-top:1px solid;border-bottom:1px solid}.contextMenu-item[data-divider]{border-color:var(--item-border)}.contextMenu-button{color:var(--item-color);background:0;border:0;white-space:nowrap;width:100%;border-radius:4px;padding:6px 24px 6px 7px;text-align:left;display:flex;align-items:center;font-size:12px;width:100%;-webkit-animation:menuItemAnimation 0.2s 0s both;animation:menuItemAnimation 0.2s 0s both;font-family:"Inter",sans-serif;cursor:pointer}.contextMenu-button:hover{background-color:var(--item-bg-hover)}.contextMenu[data-theme="light"]{--menu-bg:linear-gradient(45deg,rgba(255,255,255,.45) 0%,rgba(255,255,255,.85) 100%);--menu-border:rgba(0,0,0,.08);--item-border:rgba(0,0,0,.1);--item-color:rgb(10,20,28);--item-bg-hover:rgba(10,20,28,.09)}@-webkit-keyframes menuAnimation{0%{opacity:0;transform:scale(.5)}100%{height:var(--height);opacity:1;border-radius:8px;transform:scale(1)}}@keyframes menuAnimation{0%{opacity:0;transform:scale(.5)}100%{height:var(--height);opacity:1;border-radius:8px;transform:scale(1)}}@-webkit-keyframes menuItemAnimation{0%{opacity:0;transform:translateX(-10px)}100%{opacity:1;transform:translateX(0)}}@keyframes menuItemAnimation{0%{opacity:0;transform:translateX(-10px)}100%{opacity:1;transform:translateX(0)}}div::-webkit-scrollbar {display: none;}.pr_active>*{color : orange !important;}`;
        def.fn.setCss(css);

        function disableselect(e) { return false }
        this.onselectstart = (e) => {
            e.preventDefault();
        }
        this.onmousedown = disableselect;

        if (Array.isArray(absPlayer.src)) {
            playlist = absPlayer.src;
            var items = [];
            var urls = [];
            playlist.forEach((item, index) => {
                if (item && typeof item === 'object' && item.constructor === Object) {
                    if (item.url != '' && item.title != '') {
                        urls.push(item.url);
                        if (index == 0) {
                            playIndex = index;
                            __init(urls[index]);
                        }
                        var box = def.fn.create('div');
                        if (index == (items.length - 1)) {
                            def.fn.css(box, {
                                display: 'flex',
                                width: '100%',
                                height: '35px',
                                margin: '4px 0px',
                                position: 'relative',
                                cursor: 'pointer',
                                'padding-bottom': '120px',
                                'align-items': 'center',
                                'justify-content': 'flex-start'
                            });
                        } else {
                            def.fn.css(box, {
                                display: 'flex',
                                width: '100%',
                                height: '35px',
                                margin: '4px 0px',
                                position: 'relative',
                                cursor: 'pointer',
                                'align-items': 'center',
                                'justify-content': 'flex-start'
                            });
                        }
                        def.fn.attribute(box, {
                            'data-id': index
                        });

                        var img = def.fn.create('img');
                        def.fn.css(img, {
                            width: '30px',
                            height: '30px',
                            overflow: 'hidden',
                            cursor: 'pointer',
                            'border-radius': '50%'
                        });

                        def.fn.attribute(img, {
                            src: item.poster
                        })

                        def.fn.append(box, img);
                        var title = def.fn.create('p');

                        def.fn.css(title, {
                            'font-size': '12px',
                            color: '#fff',
                            'font-family': 'sans-serif',
                            'margin-left': '4px'
                        });
                        def.fn.html(title, item.title.slice(0, 20));
                        def.fn.attribute(img, { loading: 'lazy' });
                        def.fn.append(box, title);
                        playlistController.style.display = 'block';
                        def.fn.append(playlistContainer, box);
                        setcallBack(box, playlistActiveEvent, playlistActive);
                        playlistActive(playIndex);
                    }
                } else {
                    console.log('Please insert object data');
                }
            });
        } else {
            __init(absPlayer.src);
        }

        if (Array.isArray(absPlayer.subtitle)) {
            subtitles = absPlayer.subtitle;
            let captions = [];
            let tracksController = '';
            tracksController = `<div data-id='${100}' srclang='native' kind='off' class='pr_subtitle ${activeSubtitle == 100 ? 'pr_active' : ''}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>Off</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p></div>`;
            subtitles.forEach((item, index) => {
                if (item && typeof item === 'object' && item.constructor === Object) {
                    let itemTextTrack = `<track srclang='${item.srclang}' kind='${item.kind}' label='${item.label}' data-id='${index}' src='${item.src}' />`;
                    tracksController += `<div data-id='${index}' srclang='${item.srclang}' kind='${item.kind}' class='pr_subtitle ${activeSubtitle == index ? 'pr_active' : ''}' style='width:90%;color:#fff;height:28px; padding:2px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${item.label}</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p></div>`;
                    captions.push(itemTextTrack);
                } else {
                    return;
                }
            });

            itemSubtitle.addEventListener('click', () => {
                loadTextTracks();
            })

            function loadTextTracks() {
                if (playername == 'mp4' | playername == 'mkv' | playername == 'flv') {
                    def.fn.html(settingsOptionAfter, '');
                    def.fn.html(video, captions);

                    def.fn.html(settingsOptionAfter, tracksController);
                    def.fn.append(settingsOptionAfter, settingsBack);
                    settingsOptionBefore.style.display = "none";
                    settingsOptionAfter.style.display = "flex";

                    const hlsCaptions = document.querySelectorAll(".pr_subtitle");
                    hlsCaptions.forEach((item, index) => {
                        setcallBack(item, textTrackChange);
                    })
                }
            }


            function textTrackChange(e) {
                let kind = e.getAttribute('kind');
                let value = e.getAttribute('srclang');
                activeSubtitle = e.getAttribute("data-id");
                if (value === 'off') {
                    hideTextTracks();
                } else {
                    hideTextTracks();

                    for (var i = 0; i < video.textTracks.length; i++) {
                        if (video.textTracks[i].kind === kind) {
                            if (video.textTracks[i].language === value) {
                                video.textTracks[i].mode = 'showing';
                            }
                        }
                    }
                }

                const hlsCaptions = document.querySelectorAll(".pr_subtitle");
                for (let i = 0; i < hlsCaptions.length; i++) {
                    def.fn.removeClass(hlsCaptions[i], 'pr_active');
                    if (activeSubtitle == hlsCaptions[i].getAttribute('data-id')) {
                        def.fn.addClass(hlsCaptions[i], 'pr_active');
                    }
                }
            }

            function hideTextTracks() {
                for (var s = 0; s < video.textTracks.length; s++) {
                    video.textTracks[s].mode = 'hidden';
                }
            }
        }

        function launchIntoFullscreen(element) {
            if (element.requestFullscreen) {
                element.requestFullscreen();
            } else if (element.mozRequestFullScreen) {
                element.mozRequestFullScreen();
            } else if (element.webkitRequestFullscreen) {
                element.webkitRequestFullscreen();
            } else if (element.msRequestFullscreen) {
                element.msRequestFullscreen();
            }
            if (absPlayer.v360) {
                let canvas360 = document.querySelector('canvas');
                canvas360.style.width = "100%";
                canvas360.style.height = "100%";
            }
            if (isMobile) {
                const oppositeOrientation = screen.orientation.type.startsWith("portrait")
                    ? "landscape"
                    : "portrait";
                screen.orientation
                    .lock(oppositeOrientation)
                    .then(() => {
                        console.log(`Locked to ${oppositeOrientation}\n`)
                    })
                    .catch((error) => {
                        console.log(`${error}\n`)
                    });
            }
            def.fn.html(screenController, def.icons.fullScreenOut);
        }

        function exitFullscreen() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
            if (absPlayer.v360) {
                let canvas360 = document.querySelector('canvas');
                canvas360.style.width = "100%";
                canvas360.style.height = "100%";
            }
            if(isMobile){
                screen.orientation.unlock();
            }
            def.fn.html(screenController, def.icons.faullScreenEnter);
        }
        var fullscreen = false;

        function toggleFullscreen() {
            if (fullscreen) {
                exitFullscreen();
            } else {
                launchIntoFullscreen(player);
            }
            fullscreen = !fullscreen;
        }


        function togglePlayback(e) {
            activePlayback = e.getAttribute("index");
            const removePlayback = document.querySelectorAll(".pr_playback");
            for (let i = 0; i < removePlayback.length; i++) {
                def.fn.removeClass(removePlayback[i], 'pr_active');
                if (activePlayback == removePlayback[i].getAttribute('index')) {
                    def.fn.addClass(removePlayback[i], 'pr_active');
                }
            }

            def.fn.addClass(e, 'pr_active');
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                if (absPlayer.v360) {
                    video360.playbackRate = e.getAttribute('play-rate');
                } else {
                    video.playbackRate = e.getAttribute("play-rate");
                }
            } else if (isYoutube == 'yTb') {
                youtubePlayer.setPlaybackRate(Number(getSpeedIndex(ytSpeed, e.getAttribute("play-rate"))));
            } else if (playername == 'vimeo') {
                vmPlayer.setPlaybackRate(e.getAttribute('play-rate'));
            }
        }


        function togglePlaybackLoop(e) {
            activeLoop = e.getAttribute('data-id');
            const allLoops = document.querySelectorAll(".pr_loop");
            for (let a = 0; a < allLoops.length; a++) {
                def.fn.removeClass(allLoops[a], 'pr_active');
                if (activeLoop == allLoops[a].getAttribute('data-id')) {
                    def.fn.addClass(allLoops[a], 'pr_active');
                }
            }

            if ((fileExtention == "mp4") || (fileExtention == "webm") || (fileExtention == "ogg") || fileExtention == "m3u8" || fileExtention == 'mpd') {
                if (absPlayer.v360) {
                    if (e.getAttribute("data-id") == 1) {
                        def.fn.attribute(video360, {
                            loop: true
                        });
                    } else {
                        def.fn.remove_attribute(video360, {
                            loop: false
                        });
                    }
                } else {
                    if (e.getAttribute("data-id") == 1) {
                        def.fn.attribute(video, {
                            loop: true
                        });
                    } else {
                        def.fn.remove_attribute(video, {
                            loop: false
                        });
                    }
                }
            } else if (playername == 'youtube' && youtubePlayer != null) {
                if (e.getAttribute("data-id") == 1) {
                    youtubePlayer.setLoop(true);
                } else {
                    youtubePlayer.setLoop(false);
                }
            } else if (playername == 'vimeo') {
                if (e.getAttribute("data-id") == 1) {
                    vmPlayer.setLoop(true);
                } else {
                    vmPlayer.setLoop(false);
                }
            }
        }

        
        function toggleShare(){
            if(shareArea.style.display == 'none'){
                let e = document.location.href,
                    t = "Share with your favorite one";
                    window.location.origin;
                const shareItem = [
                    [
                        def.icons.facebookIcon,
                        "Facebook",
                        "https://www.facebook.com/sharer.php?u=" + e

                    ],
                    [
                        def.icons.twitterIcon,
                        "Twitter",
                        "https://twitter.com/share?url=" + e + "&text=" + t

                    ],
                    [
                        def.icons.linkedinIcon,
                        "Linkedin",
                        "https://www.linkedin.com/shareArticle?url=" + e

                    ],
                    [
                        def.icons.whatsapIcon,
                        "Whatsapp",
                        "https://api.whatsapp.com/send?text=" + t + ",url=" + e

                    ],
                    [
                        def.icons.redditIcon,
                        "Reddit",
                        "https://reddit.com/submit?url=" + e + "&title=" + t

                    ],
                ];

                shareBox = def.fn.create('div');
                def.fn.css(shareBox,{
                    position: 'absolute',
                    width: '100%',
                    height: '100%',
                    background: 'rgba(0,0,0,0.4)',
                    'z-index': 999999,
                    display: 'flex',
                    'align-items': 'center',
                    'justify-content':'center',
                    gap: '40px',
                    margin: '0px',
                    padding: '10px 15px'
                });
                def.fn.append(shareArea, shareBox);

                shareItem.forEach((item,index)=>{
                    shareLink = def.fn.create('a');
                    def.fn.css(shareLink,{
                        width: '30px',
                        height: '30px',
                        color: '#fff',
                        'font-size': '24px',
                        'text-decoration': 'none'
                    });

                    def.fn.attribute(shareLink,{
                        href: item[2],
                        title: item[1],
                        target: '_blank'
                    });
                    def.fn.html(shareLink,item[0]);
                    def.fn.append(shareBox,shareLink);
                })
                shareArea.style.display = 'flex';
            }else{
                shareArea.style.display = 'none';
            }
        }

        function videoListener() {
            if (absPlayer.v360) {
                videoEvent(video360);
            } else {
                videoEvent(video);
            }
        }

        function videoEvent(videoItem) {
            videoItem.addEventListener("waiting", () => {
                loader.style.display = "block";
            });

            videoItem.addEventListener('click', () => {
                togglePlayPause();
            });

            videoItem.addEventListener('playing', () => {
                isPlaying = true;
                loader.style.display = 'none';
            });

            videoItem.addEventListener('ended', () => {
                video.currentTime = 0;
                videoEnded();
                isVideoEnded = true;
                def.fn.html(playPauseControll, def.icons.playBtn);
            });

            videoItem.addEventListener("timeupdate", () => {
                isPlaying = true;
                def.fn.html(playPauseControll, def.icons.pauseBtn);
                getCurrentDuration();
            });

            videoItem.addEventListener("loadeddata", () => {
                getFullDuration();
            });

            videoItem.addEventListener('pause', () => {
                def.fn.html(playPauseControll, def.icons.playBtn);
            })

            videoItem.addEventListener("progress", () => {
                const duration = videoItem.duration;
                if (duration > 0) {
                    for (let i = 0; i < video.buffered.length; i++) {
                        if (
                            videoItem.buffered.start(videoItem.buffered.length - 1 - i) <
                            videoItem.currentTime
                        ) {
                            progressBuffer.style.width = `${(videoItem.buffered.end(videoItem.buffered.length - 1 - i) * 100) /
                                duration
                                }%`;
                            break;
                        }
                    }
                }
            });
        }


        function touchvolumeHide() {
            let tv = 0;
            const tvTimer = setInterval(() => {
                tv++;
                if (tv >= 4) {
                    clearInterval(tvTimer);
                    tv = 0;
                    if (volumeSlider != undefined) {
                        def.fn.css(volumeSlider, {
                            width: '0px',
                            height: '5px',
                            background: 'red',
                            cursor: 'pointer',
                            transition: '0.5s'
                        });

                        def.fn.css(volumeSliderArea, {
                            width: '0px',
                            height: '5px',
                            background: 'gray',
                            cursor: 'pointer',
                            transition: '0.5s'
                        });
                        isSoundOpen = false;
                    }
                }
            })
        }

        function __init(url) {
            fileExtention = extChecker(url);
            isYoutube = APIYoutube(url);
            isVimeo = APIVimeo(url);
            setDefaultVolume();

            if ((fileExtention == "mp4") | (fileExtention == "webm") | (fileExtention == "ogg") | (fileExtention == 'm4s')) {
                isVideoEnded = false;
                if (absPlayer.v360) {
                    v360();
                } else {
                    if (encrypt == true) {
                        video.src = isEncrypt(url);
                    } else {
                        video.src = url;
                    }
                    video.setAttribute("type", typeGenerator(fileExtention));
                    video.load();
                    videoListener();
                }
                playername = 'mp4';
            }

            if (fileExtention == 'mkv') {
                isVideoEnded = false;
                if (isCast) {
                    video.setAttribute("type", typeGenerator(fileExtention));
                    video.src = url;
                    video.load();
                    videoListener();
                } else {
                    console.log("Your browser doesn't support the mkv file. Open with Google Chrome");
                }
                playername = 'mp4';
            }

            if (fileExtention == 'flv') {
                isVideoEnded = false;
                videoListener();
                function loadFlv() {
                    (function loadVimeoScript() {
                        const tag = document.createElement('script');
                        tag.src = "https://bilibili.github.io/flv.js/dist/flv.js";
                        const firstScriptTag = document.getElementsByTagName('script')[0];
                        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                        tag.onload = setupFLV;
                    })();
                    def.fn.attribute(video, {
                        type: 'video/x-flv;audio/mp4;codecs=mp3'
                    });

                    function setupFLV() {
                        var flvPlayer = flvjs.createPlayer({
                            type: 'flv',
                            url: url
                        });
                        flvPlayer.attachMediaElement(video);
                        flvPlayer.load();
                        flvPlayer.play();
                    }

                }
                if (document.readyState !== "loading") {
                    console.info(`document.readyState ==>`, document.readyState);
                    loadFlv();
                } else {
                    document.addEventListener("DOMContentLoaded", function () {
                        console.info(`DOMContentLoaded ==>`, document.readyState);
                        loadFlv();
                    });
                }

                playername = 'flv';
            }

            if (fileExtention == "m3u8") {
                isVideoEnded = false;
                videoListener();
                playername = 'hls';
                let hlsData = undefined;
                let scriptsPromise = (async () => {
                    await loadScript(
                        "https://cdnjs.cloudflare.com/ajax/libs/hls.js/1.2.7/hls.min.js"
                    );
                    if (Hls.isSupported()) {
                        var hls = new Hls({
                            debug: false,
                        });
                        if (encrypt == true) {
                            hls.loadSource(isEncrypt(url));
                        } else {
                            hls.loadSource(url);
                        }
                        hls.attachMedia(video);
                        hls.currentLevel = 0;

                        hls.on(Hls.Events.MEDIA_ATTACHED, function () {
                            ext = "application/x-mpegURL";
                        });
                        hls.on(
                            Hls.Events.MANIFEST_PARSED,
                            function onAudioTrackLoaded(event, data) {
                                hlsData = data;
                            }
                        );

                        function hlsAudioTrack() {
                            hlsAudio = '';
                            if (hlsData != undefined) {
                                hlsData.audioTracks.forEach((item, index) => {
                                    const items = `<div data-id='${index}' class='pr_audio ${activeAudio == index ? 'pr_active' : ''}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='${index}'>${item.name +
                                        " " +
                                        item.groupId
                                        }</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p></div>`;
                                    hlsAudio += items;
                                })
                                def.fn.html(settingsOptionAfter, hlsAudio);
                                settingsOptionBefore.style.display = "none";
                                settingsOptionAfter.style.display = "flex";
                                def.fn.append(settingsOptionAfter, settingsBack);
                            } else {
                                return false;
                            }
                        }

                        itemAudio.addEventListener("click", () => {
                            hlsAudioTrack();

                            const audios = document.querySelectorAll(".pr_audio");
                            audios.forEach((item, index) => {
                                setcallBack(item, hlsToggleAudio);
                            })
                        });

                        function hlsToggleAudio(e) {
                            activeAudio = e.getAttribute("data-id");
                            const audios = document.querySelectorAll(".pr_audio");
                            for (let i = 0; i < audios.length; i++) {
                                def.fn.removeClass(audios[i], 'pr_active');
                                if (activeAudio == audios[i].getAttribute('data-id')) {
                                    def.fn.addClass(audios[i], 'pr_active');
                                }
                            }

                            def.fn.addClass(e, 'pr_active');
                            hls.audioTrack = e.getAttribute("data-id");
                        }

                        function hlsSubtitleTracks() {
                            hlsSubtitle = '';
                            def.fn.html(settingsOptionAfter, '');
                            if (hlsData != undefined) {
                                hlsData.subtitleTracks.forEach((item, index) => {
                                    const itemSub = `<div data-id='${index}' class='pr_subtitle ${activeSubtitle == index ? 'pr_active' : ''}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${item.name}</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p></div>`;
                                    hlsSubtitle += itemSub;
                                    hlsSubtitleUrl.push(item.url);
                                    hlsSubtitleType.push(item.type);
                                });
                                def.fn.html(settingsOptionAfter, hlsSubtitle);
                                def.fn.append(settingsOptionAfter, settingsBack);
                                settingsOptionBefore.style.display = "none";
                                settingsOptionAfter.style.display = "flex";

                                const hlsCaptions = document.querySelectorAll(".pr_subtitle");
                                hlsCaptions.forEach((item, index) => {
                                    setcallBack(item, hlsToggleCaption);
                                })
                            } else {
                                return false;
                            }
                        }

                        itemSubtitle.addEventListener("click", () => {
                            hlsSubtitleTracks();
                        });

                        function hlsToggleCaption(e) {
                            activeSubtitle = e.getAttribute("data-id");
                            const hlsCaptions = document.querySelectorAll(".pr_subtitle");
                            for (let i = 0; i < hlsCaptions.length; i++) {
                                def.fn.removeClass(hlsCaptions[i], 'pr_active');
                                if (activeSubtitle == hlsCaptions[i].getAttribute('data-id')) {
                                    def.fn.addClass(hlsCaptions[i], 'pr_active');
                                }
                            }

                            def.fn.addClass(e, 'pr_active');
                            hls.subtitleTrack = e.getAttribute("data-id");
                        }

                        function setHLSLevel(level) {
                            let nLevel = "";
                            level >= 160 && level < 239 ? (nLevel = 160) : "auto";
                            level >= 240 && level < 359 ? (nLevel = 240) : "auto";
                            level >= 360 && level < 479 ? (nLevel = 360) : "auto";
                            level >= 480 && level < 539 ? (nLevel = 480) : "auto";
                            level >= 540 && level < 719 ? (nLevel = 540) : "auto";
                            level >= 720 && level < 1079 ? (nLevel = 720) : "auto";
                            level >= 1080 && level < 1379 ? (nLevel = 1080) : "auto";
                            level >= 1380 && level < 1780 ? (nLevel = 1444) : "auto";

                            return nLevel;
                        }

                        function setHLSBandwidth(band) {
                            if (band != undefined && band != '') {
                                const stBand = band.toString();
                                let newBand;
                                band <= 999999
                                    ? (newBand = stBand.substr(0, 3))
                                    : (newBand = stBand.substr(0, 4));
                                return newBand;
                            } else {
                                return 360;
                            }
                        }

                        function hlsQuality() {
                            hlsItem = '';
                            def.fn.html(settingsOptionAfter, '');
                            if (hlsData != undefined) {
                                hlsItem += `<div data-id='0' class='pr_quality ${activeQuality == 0 || activeQuality == undefined ? 'pr_active' : ''}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='0'>Auto</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='0'>${def.icons.rightArrow}</p></div>`;
                                hlsData.levels.forEach((item, index) => {
                                    hlsFile.push(item.url[0]);
                                    const items = `<div data-id='${index + 1
                                        }' class='pr_quality ${activeQuality == (index + 1) ? 'pr_active' : ''}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='margin:0!important;font-size:12px;'>${setHLSLevel(item.height) +
                                        " <span style='font-size:12px;color:orange;font-family:sans-serif;'>(" +
                                        setHLSBandwidth(item.attrs["BANDWIDTH"]) +
                                        ")</span>kbps"
                                        }</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' >${def.icons.rightArrow}</p></div>`;
                                    hlsItem += items;
                                });
                                def.fn.html(settingsOptionAfter, hlsItem);
                                settingsOptionBefore.style.display = "none";
                                settingsOptionAfter.style.display = "flex";
                                def.fn.append(settingsOptionAfter, settingsBack);

                                const qualities = document.querySelectorAll(".pr_quality");
                                qualities.forEach((item, index) => {
                                    setcallBack(item, hlsToggleQuality);
                                })
                            } else {
                                return false;
                            }
                        }

                        itemQuality.addEventListener("click", () => {
                            hlsQuality();
                        });

                        function hlsToggleQuality(e) {
                            activeQuality = e.getAttribute("data-id");
                            const qualities = document.querySelectorAll(".pr_quality");
                            for (let i = 0; i < qualities.length; i++) {
                                def.fn.removeClass(qualities[i], 'pr_active');
                                if (activeQuality == qualities[i].getAttribute('data-id')) {
                                    def.fn.addClass(qualities[i], 'pr_active');
                                }
                            }

                            def.fn.addClass(e, 'pr_active');
                            if (e.getAttribute("data-id") == 0) {
                                hls.autoLevelEnabled;
                                console.log("auto level enabled");
                            } else {
                                hls.currentLevel = e.getAttribute("data-id") - 1;
                            }
                        }
                    }
                })();
            }

            if (fileExtention == 'm3u') {
                fetch(url)
                    .then((response) => response.text())
                    .then((response) => {
                        var items = [];
                        var urls = [];


                        response.split("\n").map(function (item, index) {
                            if (item.indexOf("#EXTM3U") == -1) {
                                if (item.indexOf("#EXTINF:-1") != -1) {
                                    var et_txt = item.split(",");
                                    var info = et_txt[0].split(" ");
                                    var file_txt = item.replace('#EXTINF:-1', '');
                                    items.push({
                                        g_name: groupSanitiser(file_txt, 'tvg-id'),
                                        logo: groupSanitiser(file_txt, 'tvg-logo'),
                                        group: groupSanitiser(file_txt, 'group-title'),
                                        name: nameSanitiser(et_txt[1])
                                    });
                                } else {
                                    var ur = item.split("\r");
                                    if (ur[0].indexOf("EXTVLCOPT") == -1) {
                                        if (ur[0].length >= 1) {
                                            urls.push(ur[0]);
                                        }
                                    }
                                }
                            }

                            function sanitizeText(txt) {
                                if (txt != undefined && txt != '') {
                                    var san = txt.split("=");
                                    var sant = san[1];
                                    var index = sant.slice(1, -1);
                                    return index;
                                } else {
                                    return ' ';
                                }
                            }

                            function nameSanitiser(txt) {
                                if (txt != undefined && txt != '') {
                                    var san = txt.split("(");
                                    var sant = san[0].split("[");
                                    return sant[0].replace('\r', '');
                                } else {
                                    return ' ';
                                }
                            }

                            function groupSanitiser(txt, group_name) {
                                if (txt != undefined && txt != '') {
                                    let result = txt.indexOf(group_name + '="');
                                    let ntxt = txt.slice(result);
                                    let newIndex = ntxt.split(group_name + '="');
                                    let group_txt = newIndex[1].split('"');
                                    return group_txt[0];
                                } else {
                                    return ' ';
                                }
                            }
                        });
                        items.forEach((item, index) => {
                            if (index == 0) {
                                m3uIndex = index;
                                __init(urls[index]);
                            }
                            var box = def.fn.create('div');
                            if (index == (items.length - 1)) {
                                def.fn.css(box, {
                                    display: 'flex',
                                    width: '100%',
                                    height: '35px',
                                    margin: '4px 0px',
                                    position: 'relative',
                                    cursor: 'pointer',
                                    'padding-bottom': '120px',
                                    'align-items': 'center',
                                    'justify-content': 'flex-start'
                                });
                            } else {
                                def.fn.css(box, {
                                    display: 'flex',
                                    width: '100%',
                                    height: '35px',
                                    margin: '4px 0px',
                                    position: 'relative',
                                    cursor: 'pointer',
                                    'align-items': 'center',
                                    'justify-content': 'flex-start'
                                });
                            }
                            def.fn.attribute(box, {
                                'data-id': index
                            });

                            box.addEventListener('click', () => {
                                m3uIndex = index;
                                __init(urls[index]);
                                m3uActive(index);
                            })
                            var img = def.fn.create('img');
                            def.fn.css(img, {
                                width: '30px',
                                height: '30px',
                                overflow: 'hidden',
                                cursor: 'pointer',
                                'border-radius': '50%'
                            });
                            def.fn.attribute(img, {
                                src: item.logo
                            })
                            def.fn.append(box, img);
                            var title = def.fn.create('p');
                            def.fn.css(title, {
                                'font-size': '12px',
                                color: '#fff',
                                'font-family': 'sans-serif',
                                'margin-left': '4px'
                            });
                            def.fn.html(title, item.name.slice(0, 20));
                            def.fn.attribute(img, { loading: 'lazy' });
                            def.fn.append(box, title);
                            playlistController.style.display = 'block';
                            def.fn.append(playlistContainer, box);
                            m3uActive(m3uIndex);
                        });

                        function m3uActive(item) {
                            var allM3u = playlistContainer.querySelectorAll('div');
                            allM3u.forEach(element => {
                                if (element.getAttribute('data-id') == item) {
                                    element.style.background = 'rgba(0,0,0,0.8)';
                                } else {
                                    element.style.background = 'none';
                                }
                            });
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }

            if (fileExtention == 'mpd' || fileExtention == 'dash') {
                console.log('Dash player');
                playername = 'dash';
                isVideoEnded = false;
                videoListener();
                function loadDash() {
                    (function loadVimeoScript() {
                        const tag = document.createElement('script');
                        tag.src = "https://cdn.dashjs.org/v3.1.0/dash.all.min.js";
                        const firstScriptTag = document.getElementsByTagName('script')[0];
                        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                        tag.onload = setupDash;
                    })();
                    def.fn.attribute(video, {
                        type: 'video/webm'
                    });
                    function playerSettigs() {
                        return dashPlayer.getSettings();
                    }
                    function setupDash() {
                        dashPlayer = dashjs.MediaPlayer().create();
                        dashPlayer.initialize(
                            video,
                            url,
                            false
                        );

                        dashPlayer.setInitialMediaSettingsFor('audio', {
                            lang: 'et-ET'
                        })
                        dashPlayer.on(dashjs.MediaPlayer.events.STREAM_INITIALIZED, function _onStreamActivated(e) {
                            var streamInfo = e.streamInfo;
                            updateDuration(streamInfo.manifestInfo.isDynamic);
                            isLive = streamInfo.manifestInfo.isDynamic;

                            function dashQuality() {
                                let videoLevels = dashPlayer.getBitrateInfoListFor && dashPlayer.getBitrateInfoListFor('video') || [];

                                if (videoLevels != undefined && Array.isArray(videoLevels)) {
                                    let dashItem = '';
                                    def.fn.html(settingsOptionAfter, '');
                                    dashItem = `<div data-id='0' class='pr_quality ${activeQuality == 0 || activeQuality == undefined ? 'pr_active' : ''}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='0'>Auto</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='0'>${def.icons.rightArrow}</p></div>`;
                                    videoLevels.forEach((item, index) => {
                                        const items = `<div data-id='${index + 2
                                            }' class='pr_quality ${activeQuality == (index + 2) ? 'pr_active' : ''}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='margin:0!important;'>${item.height +
                                            " <span style='font-size:12px;color:orange;font-family:sans-serif;'>(" +
                                            setDashSBandwidth(item.bitrate) +
                                            ")</span>kbps"
                                            }</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' >${def.icons.rightArrow}</p></div>`;
                                        dashItem += items;
                                    });
                                    def.fn.html(settingsOptionAfter, dashItem);
                                    settingsOptionBefore.style.display = "none";
                                    settingsOptionAfter.style.display = "flex";
                                    def.fn.append(settingsOptionAfter, settingsBack);

                                    const qualities = document.querySelectorAll(".pr_quality");
                                    qualities.forEach((item, index) => {
                                        setcallBack(item, dashToggleQuality);
                                    })
                                }
                            }

                            itemQuality.addEventListener("click", () => {
                                dashQuality();
                            });

                            function dashToggleQuality(e) {
                                activeQuality = e.getAttribute("data-id");
                                const qualities = document.querySelectorAll(".pr_quality");
                                for (let i = 0; i < qualities.length; i++) {
                                    def.fn.removeClass(qualities[i], 'pr_active');
                                    if (activeQuality == qualities[i].getAttribute('data-id')) {
                                        def.fn.addClass(qualities[i], 'pr_active');
                                    }
                                }

                                def.fn.addClass(e, 'pr_active');
                                if (e.getAttribute("data-id") == 0) {
                                    dashBitrateSwitch('video', 0);
                                    console.log("auto level enabled");
                                } else {
                                    dashBitrateSwitch('video', e.getAttribute('data-id') - 1);
                                }
                            }

                            function dashTrack() {
                                let dashAudios = dashPlayer.getTracksFor('audio');
                                dashAudio = '';
                                def.fn.html(settingsOptionAfter, '');
                                if (dashAudios.length != undefined && Array.isArray(dashAudios)) {
                                    dashAudio = '';
                                    dashAudios.forEach((item, index) => {
                                        const items = `<div data-id='${index + 1}' class='pr_audio ${activeAudio == index ? 'pr_active' : ''}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${item.lang +
                                            " " +
                                            setDashSBandwidth(item.bitrateList[0].bandwidth)
                                            }</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p></div>`;
                                        dashAudio += items;
                                    });
                                    def.fn.html(settingsOptionAfter, dashAudio);
                                    settingsOptionBefore.style.display = "none";
                                    settingsOptionAfter.style.display = "flex";
                                    def.fn.append(settingsOptionAfter, settingsBack);

                                    const audios = document.querySelectorAll(".pr_audio");
                                    audios.forEach((item, index) => {
                                        setcallBack(item, dashToggleAudio);
                                    })
                                }
                            }
                            itemAudio.addEventListener("click", () => {
                                dashTrack();
                            });

                            function dashToggleAudio(e) {
                                activeAudio = e.getAttribute("data-id");
                                const audios = document.querySelectorAll(".pr_audio");
                                for (let i = 0; i < audios.length; i++) {
                                    def.fn.removeClass(audios[i], 'pr_active');
                                    if (activeAudio == audios[i].getAttribute('data-id')) {
                                        def.fn.addClass(audios[i], 'pr_active');
                                    }
                                }

                                def.fn.addClass(e, 'pr_active');
                                dashPlayer.setCurrentTrack(dashPlayer.getTracksFor('audio')[e.getAttribute("data-id")]);
                            }


                        });

                        dashPlayer.on(dashjs.MediaPlayer.events.TEXT_TRACKS_ADDED, function _onTracksAdded(e) {
                            console.log('tracks loaded');
                            dashSubtitle = '';
                            def.fn.html(settingsOptionAfter, '');
                            function dashCaption() {
                                let dashSubtitles = e.tracks;
                                if (dashSubtitles.length != undefined && Array.isArray(dashSubtitles)) {
                                    dashSubtitles.forEach((item, index) => {
                                        const itemSub = `<div data-id='${index}' class='pr_subtitle ${activeSubtitle == index ? 'pr_active' : ''}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${item.name}</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p></div>`;
                                        dashSubtitle += itemSub;
                                    })
                                    def.fn.html(settingsOptionAfter, dashSubtitle);
                                    def.fn.append(settingsOptionAfter, settingsBack);
                                    settingsOptionBefore.style.display = "none";
                                    settingsOptionAfter.style.display = "flex";

                                    const hlsCaptions = document.querySelectorAll(".pr_subtitle");
                                    hlsCaptions.forEach((item, index) => {
                                        setcallBack(item, dashToggleCaption);
                                    })
                                }
                            }

                            itemSubtitle.addEventListener("click", () => {
                                dashCaption();
                            });

                            function dashToggleCaption(e) {
                                activeSubtitle = e.getAttribute("data-id");
                                const hlsCaptions = document.querySelectorAll(".pr_subtitle");
                                for (let i = 0; i < hlsCaptions.length; i++) {
                                    def.fn.removeClass(hlsCaptions[i], 'pr_active');
                                    if (activeSubtitle == hlsCaptions[i].getAttribute('data-id')) {
                                        def.fn.addClass(hlsCaptions[i], 'pr_active');
                                    }
                                }

                                def.fn.addClass(e, 'pr_active');
                                dashPlayer.setTextTrack(e.getAttribute("data-id"));
                            }
                        })



                        function dashBitrateSwitch(type, index) {
                            var cfg = {
                                'streaming': {
                                    'abr': {
                                        'autoSwitchBitrate': {}
                                    }
                                }
                            };
                            if (index > 0) {
                                cfg.streaming.abr.autoSwitchBitrate[type] = false;
                                dashPlayer.updateSettings(cfg);
                                dashPlayer.setQualityFor(type, index, false);
                            } else {
                                cfg.streaming.abr.autoSwitchBitrate[type] = true;
                                dashPlayer.updateSettings(cfg);
                            }
                        }

                        function setDashSBandwidth(band) {
                            if (band != undefined && band != '') {
                                const stBand = band.toString();
                                let newBand;
                                band <= 999999
                                    ? (newBand = stBand.substr(0, 3))
                                    : (newBand = stBand.substr(0, 4));
                                return newBand;
                            } else {
                                return 360;
                            }
                        }
                        var updateDuration = function (dynamic) {
                            if (dynamic == true) {
                                def.fn.html(durationText, "<span style='color:red'>●</span> <span style='font-size:12px;color:orange'>LIVE</span>");
                            }
                        };
                    }
                }
                if (document.readyState !== "loading") {
                    console.info(`document.readyState ==>`, document.readyState);
                    loadDash();
                } else {
                    document.addEventListener("DOMContentLoaded", function () {
                        console.info(`DOMContentLoaded ==>`, document.readyState);
                        loadDash();
                    });
                }
            }

            if (isYoutube == "yTb") {
                playername = 'youtube';
                console.log("Youtube Start")
                function loadVideo() {
                    video.style.display = 'none';
                    ytPlayer.style.display = 'flex';
                    topControls.style.display = 'flex';
                    bottomControls.style.display = 'flex';
                    dashItem = '';
                    dashAudio = '';
                    dashSubtitle = '';
                    hlsItem = '';
                    hlsAudio = '';
                    hlsSubtitle = '';
                    openControls();
                    controlResizer();
                    isVideoEnded = false;
                    let ytActualQuality = 'medium';
                    if (playername == 'youtube' && youtubePlayer != null) {
                        loadingVideo(ytEvent, youtubeID(url));
                        setTimeout(function () {
                            youtubePlayer.playVideo();
                        }, 300);
                        getFullDuration();
                    } else {
                        (function loadYoutubeIFrameApiScript() {
                            const tag = document.createElement("script");
                            tag.src = "https://www.youtube.com/iframe_api";

                            const firstScriptTag = document.getElementsByTagName("script")[0];
                            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                            tag.onload = setupPlayer;
                        })();
                    }

                    function setupPlayer() {
                        window.YT.ready(function () {
                            youtubePlayer = new window.YT.Player("ytIframe", {
                                height: "390",
                                width: "640",
                                videoId: youtubeID(url),
                                playerVars: {
                                    'autohide': 0,
                                    'cc_load_policy': 0,
                                    'controls': 0,
                                    'disablekb': 1,
                                    'iv_load_policy': 3,
                                    'modestbranding': 1,
                                    'rel': 0,
                                    'showinfo': 0,
                                    'start': 0,
                                    'autoplay': 1,
                                    enablejsapi: 1,
                                    playerapiid: "pr_YtPlayer",
                                    html5: 1,
                                },
                                events: {
                                    onReady: onPlayerReady,
                                    onPlaybackQualityChange: onPlayerPlaybackQualityChange,
                                    onStateChange: onPlayerStateChange,
                                }
                            });
                        });
                    }


                    function youTubePlayerActive() {
                        currentEvent.info = youtubePlayer.playerInfo;
                        currentEvent.isPlaying = youtubePlayer.getPlayerState();
                        currentEvent.duration = youtubePlayer.getDuration();
                        currentEvent.currentTime = youtubePlayer.getCurrentTime();
                        currentEvent.volume = youtubePlayer.getVolume();
                        currentEvent.subtitle = youtubePlayer.cuePlaylist();
                        currentEvent.buffer = currentEvent.info.videoLoadedFraction;
                        getCurrentDuration();
                        getFullDuration();
                        currentEventChecker();
                        getBuffer();

                        if (playername == 'youtube' && currentEvent.info != undefined && currentEvent.info.videoData != undefined) {
                            if (currentEvent.info.videoData.isLive == true) {
                                isLive = true;
                            }
                        }
                        setTimeout(youTubePlayerActive, 1000);
                    }


                    ytPlayer.addEventListener('mousedown', (e) => {
                        e.preventDefault();
                        if (e.button == 2) {
                            return false
                        }
                    });


                    function ytQualities() {
                        let data = currentEvent.info.availableQualityLevels;
                        currentEvent.qualityLabel = '';
                        def.fn.html(settingsOptionAfter, '');
                        if (Array.isArray((data)) && currentEvent.qualityLabel == '') {
                            for (let q = 0; q < data.length; q++) {
                                switch (data[q]) {
                                    case 'highres':
                                        currentEvent.quality.push(4320);
                                        currentEvent.qualityLabel += `<div data-id='4320' class='ytQuality ${activeQuality == '4320' ? 'pr_active' : ''}' style='width:90%;color:#fff;height:20px; margin:3px 0px;padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='4320'>4320p<sup data-id="4320">8k</sup></p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='4320'>${def.icons.rightArrow}</p></div>`
                                        break;
                                    case 'hd2160':
                                        currentEvent.quality.push(2160);
                                        currentEvent.qualityLabel += `<div data-id='2160' class='ytQuality ${activeQuality == '2160' ? 'pr_active' : ''}' style='width:90%;color:#fff;height:20px; margin:3px 0px;padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='2160'>2160p<sup data-id="2160">4k</sup></p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='2160'>${def.icons.rightArrow}</p></div>`
                                        break;
                                    case 'hd1440':
                                        currentEvent.quality.push(1440);
                                        currentEvent.qualityLabel += `<div data-id='1440' class='ytQuality ${activeQuality == '1440' ? 'pr_active' : ''}' style='width:90%;color:#fff;height:20px; margin:3px 0px;padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='1440'>1440p<sup data-id="1440">2k</sup></p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='1440'>${def.icons.rightArrow}</p></div>`
                                        break;
                                    case 'hd1080':
                                        currentEvent.quality.push(1080);
                                        currentEvent.qualityLabel += `<div data-id='1080' class='ytQuality ${activeQuality == '1080' ? 'pr_active' : ''}' style='width:90%;color:#fff;height:20px; margin:3px 0px;padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='1080'>1080p<sup data-id="1080">hd</sup></p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='1080'>${def.icons.rightArrow}</p></div>`
                                        break;
                                    case 'hd720':
                                        currentEvent.quality.push(720);
                                        currentEvent.qualityLabel += `<div data-id='720' class='ytQuality ${activeQuality == '720' ? 'pr_active' : ''}' style='width:90%;color:#fff;height:20px; margin:3px 0px;padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='720'>720p<sup data-id="720">hd</sup></p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='720'>${def.icons.rightArrow}</p></div>`
                                        break;
                                    case 'large':
                                        currentEvent.quality.push(480);
                                        currentEvent.qualityLabel += `<div data-id='480' class='ytQuality ${activeQuality == '480' ? 'pr_active' : ''}' style='width:90%;color:#fff;height:20px; margin:3px 0px;padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='480'>480p<sup></sup></p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='480'>${def.icons.rightArrow}</p></div>`
                                        break;
                                    case 'medium':
                                        currentEvent.quality.push(360);
                                        currentEvent.qualityLabel += `<div data-id='360' class='ytQuality ${activeQuality == '360' ? 'pr_active' : ''}' style='width:90%;color:#fff;height:20px; margin:3px 0px;padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='360'>360p</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='360'>${def.icons.rightArrow}</p></div>`
                                        break;
                                    case 'small':
                                        currentEvent.quality.push(240);
                                        currentEvent.qualityLabel += `<div data-id='240' class='ytQuality ${activeQuality == '240' ? 'pr_active' : ''}' style='width:90%;color:#fff;height:20px; margin:3px 0px;padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='240'>240p</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='240'>${def.icons.rightArrow}</p></div>`
                                        break;
                                    case 'tiny':
                                        currentEvent.quality.push(144);
                                        currentEvent.qualityLabel += `<div data-id='144' class='ytQuality ${activeQuality == '144' ? 'pr_active' : ''}' style='width:90%;color:#fff;height:20px; margin:3px 0px;padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='144'>144p</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='144'>${def.icons.rightArrow}</p></div>`
                                        break;
                                    default:
                                        currentEvent.quality.push(100);
                                        currentEvent.qualityLabel += `<div data-id='100' class='ytQuality ${activeQuality == '100' ? 'pr_active' : ''}' style='width:90%;color:#fff;height:20px; margin:3px 0px;padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='100'>auto</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;' data-id='100'>${def.icons.rightArrow}</p></div>`
                                }
                            }
                        }
                        settingsOptionBefore.style.display = "none";
                        settingsOptionAfter.style.display = "flex";
                        def.fn.html(settingsOptionAfter, currentEvent.qualityLabel);
                        def.fn.append(settingsOptionAfter, settingsBack);

                        const qualities = document.querySelectorAll(".ytQuality");
                        qualities.forEach((item, index) => {
                            setcallBack(item, ytToggleQuality);
                            if (item.getAttribute('data-id') == activeQuality) {
                                def.fn.addClass(item, 'pr_active');
                            }
                        })
                    }

                    function setYtQuality(q) {
                        let quality;
                        switch (q) {
                            case '4320':
                                quality = 'highres';
                                break;
                            case '2160':
                                quality = 'hd2160';
                                break;
                            case '1440':
                                quality = 'hd1440';
                                break;
                            case '1080':
                                quality = 'hd1080';
                                break;
                            case '720':
                                quality = 'hd720';
                                break;
                            case '480':
                                quality = 'large';
                                break;
                            case '360':
                                quality = 'medium';
                                break;
                            case '240':
                                quality = 'small';
                                break;
                            case '144':
                                quality = 'tiny';
                                break;
                            case '100':
                                quality = 'auto';
                                break;
                        }
                        return quality;
                    }

                    function currentEventChecker() {
                        if (currentEvent.isPlaying == 5 || currentEvent.isPlaying == -1 || currentEvent.isPlaying == 2 || currentEvent.isPlaying == '') {
                            isPlaying = false;
                            if (playername == 'youtube') {
                                controlResizer();
                                playPauseControll.innerHTML = def.icons.playBtn;
                            }
                        } else {
                            if (playername == 'youtube') {
                                isPlaying = true;
                                playPauseControll.innerHTML = def.icons.pauseBtn;
                            }
                        }

                        if (currentEvent.isPlaying == 0 && isVideoEnded == false) {
                            if (playername == 'youtube') {
                                isVideoEnded = true;
                                videoEnded();
                            }
                        }
                    }

                    itemQuality.addEventListener("click", () => {
                        ytQualities();
                    })

                    itemSubtitle.addEventListener('click', () => {
                        console.log('clicked');
                    })

                    function ytToggleQuality(e) {
                        activeQuality = e.getAttribute('data-id');
                        const qualities = document.querySelectorAll(".ytQuality");
                        for (let q = 0; q < qualities.length; q++) {
                            def.fn.removeClass(qualities[q], 'pr_active');
                            if (qualities[q].getAttribute('data-id') == activeQuality) {
                                ytActualQuality = setYtQuality(qualities[q].getAttribute('data-id'));
                                def.fn.addClass(qualities[q], 'pr_active');
                                qualities[q].style.color = "orange";
                                youtubePlayer.pauseVideo();
                                youtubePlayer.playerInfo.playbackQuality = setYtQuality(qualities[q].getAttribute('data-id'));
                                youtubePlayer.setPlaybackQuality(getQualityIndex(ytQualityText, setYtQuality(qualities[q].getAttribute('data-id'))))
                                youtubePlayer.loadVideoById({
                                    'videoId': youtubeID(url),
                                    'startSeconds': currentEvent.currentTime,
                                    'suggestedQuality': setYtQuality(qualities[q].getAttribute('data-id'))
                                });
                                youtubePlayer.playVideo();
                            }
                        }
                    }

                    function onPlayerPlaybackQualityChange(event) {
                        event.target.setPlaybackQuality(ytActualQuality);
                        youtubePlayer.setPlaybackQuality(ytActualQuality);
                    }

                    function setNewQuality(q) {
                        youtubePlayer.loadVideoById({
                            'videoId': youtubePlayer.videoId,
                            'startSeconds': 0,
                            'suggestedQuality': q
                        });
                        youtubePlayer.playVideo();
                    }

                    function loadingVideo(event, q) {
                        event.target.cueVideoById({
                            'videoId': q,
                            'startSeconds': 0
                        });
                        youtubePlayer.playVideo();
                    }

                    function onPlayerReady(event) {
                        ytEvent = event;
                        youTubePlayerActive();
                        getFullDuration()
                        togglePlayPause()
                        loadingVideo(event, youtubeID(url));

                    }

                    function onPlayerStateChange(event) {
                        var videoStatuses = Object.entries(window.YT.PlayerState);
                        const state = event.target.getPlayerState();
                    }

                    setDefaultVolume();
                }

                if (document.readyState !== "loading") {
                    console.info(`document.readyState ==>`, document.readyState);
                    loadVideo();
                } else {
                    document.addEventListener("DOMContentLoaded", function () {
                        console.info(`DOMContentLoaded ==>`, document.readyState);
                        loadVideo();
                    });
                }

                function youtubeID(URL) {
                    let url;
                    if (encrypt == true) {
                        url = atob(URL);
                    } else {
                        url = URL;
                    }
                    const regex =
                        /(?:https?:)?(?:\/\/)?(?:[0-9A-Z-]+\.)?(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/\S*?[^\w\s-])((?!videoseries)[\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:['"][^<>]*>|<\/a>))[?=&+%\w.-]*/;
                    const newValue = url.match(regex);
                    if (regex.test(url)) {
                        return newValue[1];
                    }
                }
            }

            if (isVimeo && isVimeo != '') {
                playername = 'vimeo';
                console.log("Vimeo video start");
                function loadVimeo() {
                    isVideoEnded = false;
                    video.style.display = 'none';
                    vimeoPlayer.style.display = 'block';
                    vimeoClick.style.display = 'block';
                    let vmqualityLabel = '';

                    (function loadVimeoScript() {
                        const tag = document.createElement('script');
                        tag.src = "https://player.vimeo.com/api/player.js";
                        const firstScriptTag = document.getElementsByTagName('script')[0];
                        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                        tag.onload = setupVimeo;
                    })();

                    function setupVimeo() {
                        const vmOptions = {
                            id: isVimeo,
                            width: vimeoPlayer.offsetWidth,
                            height: vimeoPlayer.offsetHeight,
                            controls: false,
                            responsive: true,
                        };

                        vmPlayer = new Vimeo.Player('vmFrame', vmOptions);

                        vmPlayer.on('play', function () {
                            vmActive = true;
                            isPlaying = true;
                            durationCurrent.innerHTML = formatDuration(vmCurrentTime);
                        });
                        vmPlayer.on('pause', function () {
                            vmActive = false;
                            durationCurrent.innerHTML = formatDuration(vmCurrentTime);
                        });

                        function getVmQuality() {
                            vmqualityLabel = '';
                            def.fn.html(settingsOptionAfter, '');
                            vmPlayer.getQualities().then(function (qualities) {
                                qualities.forEach((item, index) => {
                                    vmqualityLabel += `<div data-id='${item.id}' class='vmQuality ${activeQuality == item.id ? 'pr_active' : ''}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${item.label}</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p></div>`
                                });
                                def.fn.html(settingsOptionAfter, vmqualityLabel);
                                settingsOptionBefore.style.display = "none";
                                settingsOptionAfter.style.display = "flex";
                                def.fn.append(settingsOptionAfter, settingsBack);

                                const vqualities = settingsOptionAfter.querySelectorAll(".vmQuality");
                                vqualities.forEach((item, index) => {
                                    setcallBack(item, vmQualitySet);
                                    if (item.getAttribute('data-id') == activeQuality) {
                                        def.fn.addClass(item, 'pr_active');
                                    }
                                })
                            }).catch(function (error) {
                                console.log(error)
                            });
                        }

                        itemQuality.addEventListener("click", () => {
                            if (playername == 'vimeo') {
                                getVmQuality();
                            }
                        });

                        function vmSubtitles() {
                            vmPlayer.getTextTracks().then(function (tracks) {
                                hlsSubtitle = '';
                                tracks.forEach((item, index) => {
                                    const itemSub = `<div data-id='${item.language}' class='pr_subtitle ${activeSubtitle == item.language ? 'pr_active' : ''}' style='width:90%;color:#fff;height:28px; padding:5px 2px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;'><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${item.label}</p><p style='font-size:12px;font-family:sans-serif;margin:0 !important;'>${def.icons.rightArrow}</p></div>`;
                                    hlsSubtitle += itemSub;
                                });

                                settingsOptionBefore.style.display = "none";
                                settingsOptionAfter.style.display = "flex";
                                def.fn.html(settingsOptionAfter, hlsSubtitle);
                                def.fn.append(settingsOptionAfter, settingsBack);

                                const qualities = document.querySelectorAll(".pr_subtitle");
                                qualities.forEach((item, index) => {
                                    setcallBack(item, vmSubtitleSet);
                                    if (item.getAttribute('data-id') == activeQuality) {
                                        def.fn.addClass(item, 'pr_active');
                                    }
                                })
                            }).catch(function (error) {
                                console.log(error)
                            });
                        }

                        itemSubtitle.addEventListener("click", () => {
                            if (playername == 'vimeo') {
                                vmSubtitles();
                            }
                        })

                        vmPlayer.disableTextTrack().then(function () {
                            console.log('Disabled captions')
                        }).catch(function (error) {
                            console.log(error)
                        });

                        vmPlayer.getDuration().then(function (duration) {
                            vmDuration = duration
                            getFullDuration(vmDuration);
                            durationText.innerHTML = formatDuration(vmDuration);
                        }).catch(function (error) {
                            console.log(error);
                        });

                        vmPlayer.on('timeupdate', function (crTime) {
                            vmCurrentTime = crTime.seconds;
                            durationCurrent.innerHTML = formatDuration(vmCurrentTime);
                            getCurrentDuration();
                            buffered();
                        });

                        vmPlayer.on('ended', function (data) {
                            isVideoEnded = true;
                            videoEnded();
                        })

                        let vmsoundWidth = localStorage.getItem('pr_active_sound') ?? 20;
                        vmPlayer.setVolume(vmsoundWidth / 100).then(function (volume) {
                            return;
                        }).catch(function (error) {
                            console.log(error);
                        });

                        function buffered() {
                            vmPlayer.getBuffered().then(function (buffered) {
                                if (playername == 'vimeo') {
                                    progressBuffer.style.width = parseInt(buffered[0][1] * progress.offsetWidth) / vmDuration + buffered[0][1] + "px";
                                }
                            }).catch(function (error) {
                                console.log(error);
                            });
                        }

                        function vmQualitySet(e) {
                            activeQuality = e.getAttribute('data-id');
                            const qualities = document.querySelectorAll(".vmQuality");
                            qualities.forEach((item, index) => {
                                def.fn.removeClass(item, 'pr_active');
                                if (item.getAttribute('data-id') == activeQuality) {
                                    def.fn.addClass(item, 'pr_active');
                                }
                            })

                            vmPlayer.setQuality(activeQuality).then(function (quality) {
                                console.log(quality);
                            }).catch(function (error) {
                                console.log(error)
                            });
                        }

                        function vmSubtitleSet(e) {
                            activeSubtitle = e.getAttribute('data-id');
                            const qualities = document.querySelectorAll(".pr_subtitle");
                            qualities.forEach((item, index) => {
                                def.fn.removeClass(item, 'pr_active');
                                if (item.getAttribute('data-id') == activeSubtitle) {
                                    def.fn.addClass(item, 'pr_active');
                                }
                            })

                            vmPlayer.enableTextTrack(activeSubtitle).then(function (track) {
                                console.log(track);
                            }).catch(function (error) {
                                console.log(error)
                            });
                        }
                    }

                }
                if (document.readyState !== "loading") {
                    console.info(`document.readyState ==>`, document.readyState);
                    loadVimeo();
                } else {
                    document.addEventListener("DOMContentLoaded", function () {
                        console.info(`DOMContentLoaded ==>`, document.readyState);
                        loadVimeo();
                    });
                }
            }

            if (isCast && isCastEnable == false) {
                isCastEnable = true;
                console.log("Cast starting");
                castControl.style.display = 'block';
                function loadCast() {
                    (function loadAdsScript() {
                        const tag = document.createElement('script');
                        tag.src = "https://www.gstatic.com/cv/js/sender/v1/cast_sender.js?loadCastFramework=1";
                        const firstScriptTag = document.getElementsByTagName('script')[0];
                        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                        tag.onload = setupCast;
                    })();

                    function setupCast() {
                        var initializeCastApi = function () {
                            console.log('initializeCastApi');

                            var sessionRequest = new chrome.cast.SessionRequest(
                                chrome.cast.media.DEFAULT_MEDIA_RECEIVER_APP_ID);
                            var apiConfig = new chrome.cast.ApiConfig(
                                sessionRequest, sessionListener, receiverListener);
                            chrome.cast.initialize(apiConfig, onInitSuccess, onError);
                        };

                        if (!chrome.cast || !chrome.cast.isAvailable) {
                            setTimeout(initializeCastApi, 1000);
                        }

                        function onInitSuccess() {
                            console.log('onInitSuccess');
                        }

                        function onError(e) {
                            console.log('onError', e);
                        }

                        function sessionListener(e) {
                            console.log('sessionListener', e);
                        }

                        function receiverListener(availability) {
                            console.log('receiverListener', availability);

                            if (availability === chrome.cast.ReceiverAvailability.AVAILABLE) {
                                console.log("cast disabled");
                            }
                        }

                        function onSessionRequestSuccess(session) {
                            console.log('onSessionRequestSuccess', session);

                            var mediaInfo = new chrome.cast.media.MediaInfo(
                                url,
                                "video/mp4");
                            var request = new chrome.cast.media.LoadRequest(mediaInfo);
                            session.loadMedia(request, onMediaLoadSuccess, onError);
                        }

                        function onMediaLoadSuccess(e) {
                            console.log('onMediaLoadSuccess', e);
                        }
                        castControl.addEventListener('click', () => {
                            chrome.cast.requestSession(onSessionRequestSuccess, onError);
                        })
                    }
                }

                if (document.readyState !== "loading") {
                    console.info(`document.readyState ==>`, document.readyState);
                    loadCast();
                } else {
                    document.addEventListener("DOMContentLoaded", function () {
                        console.info(`DOMContentLoaded ==>`, document.readyState);
                        loadCast();
                    });
                }
            }

            function v360() {
                if (absPlayer.v360) {
                    console.log("load360 video")
                    function load360() {
                        openControls();
                        (function loadYoutubeIFrameApiScript() {
                            const tag = document.createElement("script");
                            tag.src = "https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js";

                            const firstScriptTag = document.getElementsByTagName("script")[0];
                            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                            tag.onload = setupPlayer;
                        })();

                        function setupPlayer() {
                            const scene = new THREE.Scene();
                            w360 = video.offsetWidth;
                            h360 = video.offsetHeight;
                            const camera = new THREE.PerspectiveCamera(10, w360 / h360, 1, 100);
                            const renderer = new THREE.WebGLRenderer();
                            renderer.setSize(w360, h360);
                            player360.appendChild(renderer.domElement);
                            youtubeClick.style.display = 'none';
                            video360 = document.createElement('video');
                            video360.src = url;
                            video360.playsInline = true;
                            video360.crossOrigin = "anonymous";
                            const texture = new THREE.VideoTexture(video360);
                            const geometry = new THREE.SphereGeometry(100, 32, 16 );
                            const material = new THREE.MeshBasicMaterial({ map: texture });
                            material.side = THREE.BackSide;
                            const mesh = new THREE.Mesh(geometry, material);
                            mesh.scale.set( - 1, 1, 1 );
                            scene.add( mesh );
                            renderer.setAnimationLoop(() => renderer.render(scene, camera));
                            const clamp = (v, min, max) => Math.max(min, Math.min(v, max));

                            renderer.domElement.addEventListener('wheel', e => {
                                camera.fov = clamp(camera.fov + e.deltaY / 10, 10, 100);
                                camera.updateProjectionMatrix();
                            });
                            let mouseDown = false;
                            renderer.domElement.addEventListener('mousedown', e => {
                                if (e.button === 0) mouseDown = true;
                            });
                            window.addEventListener('mouseup', e => {
                                if (e.button === 0) mouseDown = false;
                            });
                            window.addEventListener('mousemove', e => {
                                if (!mouseDown) return;
                                const { movementX, movementY } = e;
                                const rotateX = movementY / 100;
                                const rotateY = movementX / 100;
                                camera.rotateX(rotateX);
                                camera.rotateY(rotateY);
                            });

                            player360.addEventListener('touchend', e => {
                                if (e.button === 0) mouseDown = false;
                            });

                            player360.addEventListener('touchmove', e => {
                                const { movementX, movementY } = e;
                                const rotateX = movementY / 100;
                                const rotateY = movementX / 100;
                                camera.rotateX(rotateX);
                                camera.rotateY(rotateY);
                            });
                            
                            player360.addEventListener('touchstart', e => {
                                const { movementX, movementY } = e;
                                const rotateX = movementY / 100;
                                const rotateY = movementX / 100;
                                camera.rotateX(rotateX);
                                camera.rotateY(rotateY);
                            });

                            def.fn.addClass(player360, 'pr_right_option');
                            def.fn.addClass(player360, 'pr_option');
                            rightOptions('.pr_right_option', player);

                            window.addEventListener('resize', () => {
                                w360 = video.offsetWidth;
                                h360 = video.offsetHeight;
                            })
                            
                            video360.addEventListener("waiting", () => {
                                loader.style.display = "block";
                            });
                
                            video360.addEventListener('click', () => {
                                togglePlayPause();
                            });
                
                            video360.addEventListener('playing', () => {
                                isPlaying = true;
                                loader.style.display = 'none';
                            });
                
                            video360.addEventListener('ended', () => {
                                video360.currentTime = 0;
                                videoEnded();
                                isVideoEnded = true;
                                def.fn.html(playPauseControll, def.icons.playBtn);
                            });
                
                            video360.addEventListener("timeupdate", () => {
                                isPlaying = true;
                                def.fn.html(playPauseControll, def.icons.pauseBtn);
                                getCurrentDuration();
                            });
                
                            video360.addEventListener("loadeddata", () => {
                                getFullDuration();
                            });
                
                            video360.addEventListener('pause', () => {
                                def.fn.html(playPauseControll, def.icons.playBtn);
                            })
                
                            video360.addEventListener("progress", () => {
                                const duration = video360.duration;
                                if (duration > 0) {
                                    for (let i = 0; i < video360.buffered.length; i++) {
                                        if (
                                            video360.buffered.start(video360.buffered.length - 1 - i) <
                                            video360.currentTime
                                        ) {
                                            progressBuffer.style.width = `${(video360.buffered.end(video360.buffered.length - 1 - i) * 100) /
                                                duration
                                                }%`;
                                            break;
                                        }
                                    }
                                }
                            });
                        }
                    }

                    if (document.readyState !== "loading") {
                        console.info(`document.readyState ==>`, document.readyState);
                        load360();
                    } else {
                        document.addEventListener("DOMContentLoaded", function () {
                            console.info(`DOMContentLoaded ==>`, document.readyState);
                            load360();
                        });
                    }
                }
            }


            function runADS() {
                forcePause();
                if (absPlayer.vast != '') {
                    console.log("Ads video start");
                    isVast = true;
                    adsLogic();
                    controls.style.display = 'none';
                    adsHandler.style.display = 'flex';
                    function loadAds() {
                        (function loadAdsScript() {
                            const tag = document.createElement('script');
                            tag.src = "https://imasdk.googleapis.com/js/sdkloader/ima3.js";
                            const firstScriptTag = document.getElementsByTagName('script')[0];
                            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                            tag.onload = setupAds;
                        })();

                        function setupAds() {

                            let adsManager;
                            let adsLoader;
                            let adDisplayContainer;
                            let intervalTimer;
                            let videoContent;

                            function init() {
                                videoContent = adsContentVideo;
                                videoContent.volume = 0.2;
                                if (isVast == true) {
                                    adsHandler.addEventListener('click', () => {
                                        playAds();
                                    });
                                    adsHandler.addEventListener('click', () => {
                                        onContentResumeRequested();
                                    })
                                }

                                setUpIMA();
                            }

                            function setUpIMA() {
                                try {
                                    createAdDisplayContainer();
                                    google.ima.settings.setVpaidMode(google.ima.ImaSdkSettings.VpaidMode.ENABLED);
                                    adsLoader = new google.ima.AdsLoader(adDisplayContainer);
                                    adsLoader.addEventListener(
                                        google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED,
                                        onAdsManagerLoaded, false);
                                    adsLoader.addEventListener(
                                        google.ima.AdErrorEvent.Type.AD_ERROR, onAdError, false);

                                    const contentEndedListener = function () {
                                        adsLoader.contentComplete();
                                    };
                                    videoContent.onended = contentEndedListener;

                                    const adsRequest = new google.ima.AdsRequest();
                                    adsRequest.adTagUrl = absPlayer.vast;

                                    adsRequest.linearAdSlotWidth = adsContainer.offsetWidth;
                                    adsRequest.linearAdSlotHeight = adsContainer.offsetHeight;

                                    adsRequest.nonLinearAdSlotWidth = adsContainer.offsetWidth;
                                    adsRequest.nonLinearAdSlotHeight = adsContainer.offsetHeight;

                                    adsLoader.requestAds(adsRequest);
                                } catch (error) {
                                    closeCounter();
                                }
                            }


                            function createAdDisplayContainer() {

                                adDisplayContainer = new google.ima.AdDisplayContainer(
                                    document.getElementById('loader'), videoContent);
                            }


                            function playAds() {
                                if (isVast == true) {
                                    videoContent.load();
                                    adDisplayContainer.initialize();
                                    adsContainer.style.display = 'block';
                                    adsContent.style.display = 'block';
                                    adsContentVideo.style.zIndex = 99999999;
                                    adsContentVideo.style.display = 'block';
                                    try {
                                        adsManager.init(adsContainer.offsetWidth, adsContainer.offsetHeight, google.ima.ViewMode.NORMAL);
                                        adsManager.start();
                                    } catch (adError) {
                                        contentRelease();
                                    }
                                }
                            }


                            function onAdsManagerLoaded(adsManagerLoadedEvent) {
                                const adsRenderingSettings = new google.ima.AdsRenderingSettings();
                                adsRenderingSettings.restoreCustomPlaybackStateOnAdBreakComplete = true;
                                adsManager =
                                    adsManagerLoadedEvent.getAdsManager(videoContent, adsRenderingSettings);

                                adsManager.addEventListener(google.ima.AdErrorEvent.Type.AD_ERROR, onAdError);
                                adsManager.addEventListener(
                                    google.ima.AdEvent.Type.CONTENT_PAUSE_REQUESTED, onContentPauseRequested);
                                adsManager.addEventListener(
                                    google.ima.AdEvent.Type.CONTENT_RESUME_REQUESTED,
                                    onContentResumeRequested);
                                adsManager.addEventListener(
                                    google.ima.AdEvent.Type.ALL_ADS_COMPLETED, onAdEvent);

                                adsManager.addEventListener(google.ima.AdEvent.Type.LOADED, onAdEvent);
                                adsManager.addEventListener(google.ima.AdEvent.Type.STARTED, onAdEvent);
                                adsManager.addEventListener(google.ima.AdEvent.Type.COMPLETE, onAdEvent);
                                adsManager.addEventListener(google.ima.AdEvent.Type.CLICK, onAdEvent);
                            }

                            function onAdEvent(adEvent) {
                                const ad = adEvent.getAd();
                                if (adEvent.type == 'loaded') {
                                    if (!ad.isLinear()) {
                                        videoContent.play();
                                    }
                                } else if (adEvent.type == 'start') {
                                    if (ad.isLinear()) {
                                        intervalTimer = setInterval(
                                            function () {
                                            },
                                            300);
                                    }
                                } else if (adEvent.type == 'complete' || adEvent.type == 'allAdsCompleted') {
                                    contentRelease();
                                    if (ad.isLinear()) {
                                        clearInterval(intervalTimer);
                                    }
                                } else if (adEvent.type == 'click') {
                                    onContentResumeRequested();
                                }
                            }


                            function onAdError(adErrorEvent) {
                                contentRelease();
                                console.log(adErrorEvent.getError());
                                adsManager.destroy();
                            }


                            function onContentPauseRequested() {
                                videoContent.play();
                            }

                            function onContentResumeRequested() {
                                videoContent.play();
                            }

                            init();

                        }
                    }

                    function xmlVast() {
                        var vast = (absPlayer.encrypt) ? atob(absPlayer.vast) : absPlayer.vast;
                        fetch(vast)
                            .then((response) => response.text())
                            .then((response) => {
                                if ((response != undefined) | (response != "")) {
                                    let myXml = new DOMParser().parseFromString(response, "text/xml");
                                    let ads = myXml.firstChild.innerHTML ?? undefined;
                                    let adsXml = new DOMParser().parseFromString(ads, "text/xml") ?? undefined;
                                    let allAds = adsXml.querySelectorAll("Creative") ?? undefined;
                                    if (allAds != undefined) {
                                        allAds.forEach((item, index) => {
                                            let time = xmlLinkparser(item.querySelector('Duration').textContent) ?? undefined;
                                            let vastAds = xmlLinkparser(item.querySelector("MediaFile").innerHTML) ?? undefined;
                                            let vastAdsType = item.querySelector("MediaFile").getAttribute('type') ?? undefined;
                                            let vastReffer = xmlLinkparser(item.querySelector("ClickThrough").innerHTML) ?? undefined;
                                            let impressions = xmlLinkparser(adsXml.querySelector("Impression").innerHTML) ?? undefined;
                                            let Plays = xmlLinkparser(adsXml.querySelector("Plays").innerHTML) ?? undefined;
                                            let Clicks = xmlLinkparser(adsXml.querySelector("ClickTracking").innerHTML) ?? undefined;
                                            let vastImg = xmlLinkparser(item.querySelector("ClickTracking").innerHTML) ?? undefined;
                                            vastStart(vastAds, vastAdsType, vastReffer, vastImg, time, Clicks, Plays);
                                            vastImpressions(impressions)
                                        });
                                    }
                                }
                            }).catch(error => {
                                contentRelease();
                                alert('AdBlocker Detected');
                            })

                        function xmlLinkparser(link) {
                            let oldLink = link.replace('<![CDATA[', '');
                            let newLink = oldLink.replace(']]>', '');
                            return newLink.trim();
                        }

                        function vastImpressions(url) {
                            def.fn.getAjax(url, {}, (response) => {
                                console.log(response)
                            })
                        }

                        function clickHandler(url, clicks) {
                            if (window.open(url, '_blank')) {
                                def.fn.getAjax(clicks + "&data=1", {}, (response) => {
                                    console.log(response)
                                })
                            }
                        }

                        function vastStart(ads, type, url, img, duration, clicks, Plays) {
                            if (ads != undefined) {
                                def.fn.attribute(adsContentVideo, {
                                    src: ads,
                                    type: type,
                                    poster: img
                                });
                                let isClick = 'false';
                                let isAdsRunning = false;
                                adsHandler.style.display = 'none';
                                adsContainer.style.display = 'block';
                                adsContent.style.display = 'block';
                                adsContentVideo.style.display = 'block';
                                adsTimer.style.display = 'flex';
                                adsContentVideo.style.zIndex = 99999999;
                                var adsTime = duration.substring(duration.lastIndexOf(":") + 1);
                                adsContentVideo.load();
                                try {
                                    adsContentVideo.muted = true;
                                    adsContentVideo.play();
                                } catch (error) {
                                    console.log(error)
                                    adsHandler.style.display = 'flex';
                                    adsHandler.addEventListener('click', () => {
                                        adsHandler.style.display = 'none';
                                        adsContentVideo.play();
                                    })
                                }
                                adsContentVideo.addEventListener('click', () => {
                                    if (isAdsRunning == true) {
                                        clickHandler(url, clicks)
                                    } else {
                                        adsContentVideo.play();
                                    }
                                });
                                adsContentVideo.addEventListener('ended', () => {
                                    contentRelease();
                                    def.fn.getAjax(Plays, {}, (response) => {
                                        console.log(response);
                                    });
                                });
                                adsContentVideo.addEventListener('timeupdate', () => {
                                    isAdsRunning = true;
                                    adsTime = Math.ceil(adsContentVideo.duration);
                                    let adsCurrentTime = Math.floor(adsContentVideo.currentTime);
                                    def.fn.html(adsTimer, adsTime - adsCurrentTime);
                                })
                            }
                        }
                    }

                    if (document.readyState !== "loading") {
                        console.info(`document.readyState ==>`, document.readyState);
                        let adsExt = extChecker(absPlayer.vast);
                        if (!adsExt | adsExt != null) {
                            xmlVast();
                        } else {
                            if(adsExt.indexOf('xml') > -1){
                                xmlVast();
                            }else{
                                loadAds();
                            }
                        }
                    } else {
                        document.addEventListener("DOMContentLoaded", function () {
                            console.info(`document.readyState ==>`, document.readyState);
                            let adsExt = extChecker(premium.vast);
                            if (!adsExt | adsExt != null) {
                                xmlVast();
                            } else {
                                if(adsExt.indexOf('xml') > -1){
                                    xmlVast();
                                }else{
                                    loadAds();
                                }
                            }
                        });
                    }
                }
            }

            function adsWaterFall() {
                if (absPlayer.vast != '') {
                    isVast = true;
                    runADS();
                }
            } adsWaterFall();


            function adsLogic() {
                const adsCounter = setInterval(() => {
                    console.log('called adsloading')
                    if (currentDuration == 50 && isMidroll == false) {
                        isMidroll = true;
                        clearInterval(adsCounter);
                        runADS();
                    }
                }, 1000)
            }

            if (xplayer.indexOf(playername) == -1) {
                xplayer.push(playername);
            }
            hideXplayer(url);
            checkApi();
        }

        function hideXplayer(url) {
            stopPlayer();
            if (playername == 'youtube' && youtubePlayer != undefined && isYoutube == 'yTb' | isYoutube != undefined) {
                def.fn.id('ytIframe').style.display = 'flex';
                video.style.display = 'none';
                vimeoPlayer.style.display = 'none';
                setTimeout(function () {
                    youtubePlayer.playVideo();
                }, 300);
            }

            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                let myPlayer = video;
                if(absPlayer.v360){
                    myPlayer = video360;
                }
                myPlayer != undefined ? myPlayer.style.display = 'flex' : true;
                def.fn.id('ytIframe').style.display = 'none';
                vimeoPlayer.style.display = 'none';
                vimeoClick.style.display = 'none';
                setTimeout(function () {
                    myPlayer != undefined ? myPlayer.play() : true;
                }, 300);
            }

            if (playername == 'vimeo') {
                def.fn.id('ytIframe').style.display = 'none';
                video.style.display = 'none';
                vimeoPlayer.style.display = 'block';
                vimeoClick.style.display = 'block';

                if (vmPlayer != undefined && vmPlayer != null) {
                    vmPlayer.loadVideo(url).then(function (url) {
                        vmPlayer.play();
                    });
                    setTimeout(function () {
                        vmPlayer.play();
                    }, 300);
                }
                setTimeout(function () {
                    vmPlayer.play();
                }, 500);
            }
        }

        function stopPlayer() {
            xplayer.forEach(xxplayer => {
                if (xxplayer == 'mp4' | xxplayer == 'hls' | xxplayer == 'dash' | xxplayer == 'flv' | xxplayer == 'mkv') {
                    let myPlayer = video;
                    if(absPlayer.v360){
                        myPlayer = video360;
                    }
                    myPlayer != undefined ? myPlayer.pause() : true;
                }

                if (xxplayer == 'vimeo' && vmPlayer != undefined) {
                    vmPlayer.pause();
                }

                if (xxplayer == 'youtube' && youtubePlayer != undefined && isYoutube == 'yTb' | isYoutube != undefined) {
                    youtubePlayer.pauseVideo();
                }
            });
        }

        function videoEnded() {
            if (activeLoop == 0 || absPlayer.loop == 1) {
                forcePlay();
            } else {
                if (playIndex < playlist.length) {
                    playIndex++;
                    isVideoEnded = false;
                    __init(playlist[playIndex].url);
                    playlistActive(playIndex);
                } else {
                    playIndex = 0;
                    forcePause();
                    def.fn.html(playPauseControll, def.icons.pauseBtn);
                    return;
                }
            }
        }

        function playlistActive(item) {
            var allM3u = playlistContainer.querySelectorAll('div');
            allM3u.forEach(element => {
                if (element.getAttribute('data-id') == item) {
                    element.classList.add('pr_active');
                } else {
                    element.classList.remove('pr_active');
                }
            });
        }

        function playlistActiveEvent(e) {
            playIndex = e.getAttribute('data-id');
            __init(urls[playIndex]);
            playlistActive(playIndex);
        }

        function togglePlaylist() {
            if (playlistContainer.style.marginRight == '-280px') {
                playlistContainer.style.marginRight = '0px';
            } else {
                playlistContainer.style.marginRight = '-280px'
            }
        }

        function checkApi() {
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.status == 1) {
                        return true;
                    } else {
                        forcePause();
                        isApi = false;
                        def.fn.remove(player, player360);
                        def.fn.remove(player, video);
                        def.fn.remove(player, ytPlayer);
                        def.fn.remove(player, vimeoPlayer);
                        def.fn.remove(player, controls);
                        def.fn.remove(player, durationArea);
                        def.fn.remove(player, logoArea);
                        def.fn.remove(player, progress);
                        def.fn.remove(player, progressTooltip);
                        youtubeClick.removeEventListener('click',togglePlayPause);
                        errorMsg.textContent = response.message
                        return false;
                    }
                }
            };
            xhttp.open("GET", "https://abdursoft.com/license/verify/api/" + absPlayer.api_key + '/' + window.location.hostname);
            xhttp.send();
        }

        setTimeout(() => {
            checkApi();
        }, 100000)

        function contentRelease() {

            isVast = false;
            if ((fileExtention == "mp4") | (fileExtention == "webm") | (fileExtention == "ogg") | fileExtention == "m3u8" || fileExtention == 'mpd') {
                video.style.display = 'block';
            } else if (isYoutube == "yTb") {
                ytPlayer.style.display = 'flex';
            } else if (playername == 'vimeo') {
                vimeoPlayer.style.display = 'block';
            } else {
                return;
            }

            controls.style.display = 'flex';
            adsContainer.style.display = 'none';
            adsContent.style.display = 'none';
            adsContentVideo.style.display = 'none';
            adsTimer.style.display = 'none';
            adsHandler.style.display = 'none';
            forcePlay();
        }

        let closeControle = setInterval(() => {
            closeCounterNumber++;
            if (closeCounterNumber >= 5) {
                if (isMenu && isPlaying) {
                    closeControle;
                }
                closeControls();
            }
        }, 1000);

        function closeCounter() {
            if (isMenu && isPlaying) {
                closeControle;
            }
        }

        function isMouseMove() {
            closeCounterNumber = 0;
        }

        function openControls() {
            def.fn.css(controls, {
                background: controlsBG,
                width: "100%",
                height: "50px",
                position: "absolute",
                left: 0,
                bottom: 0,
                display: "flex",
                'align-items': "center",
                'flex-direction': "column",
                'z-index': normalIndex,
                transition: '0.5s'
            });
            def.fn.css(durationArea, {
                display: 'flex',
                width: '98%',
                position: 'absolute',
                left: '1%',
                right: '1%',
                bottom: '58px',
                'z-index': 99999,
                'align-items': 'center',
                'justify-content': 'space-between',
                transition: '0.5s'
            });
            progress.style.bottom = '50px';
            isMenu = true;
            closeCounter();
        }

        function closeControls() {
            if (isPlaying && isMenu) {
                def.fn.css(controls, {
                    background: controlsBG,
                    width: "100%",
                    height: "0",
                    position: "absolute",
                    left: 0,
                    bottom: '-60px',
                    display: "flex",
                    'align-items': "center",
                    'flex-direction': "column",
                    'z-index': 999999,
                    transition: '0.5s'
                });
                def.fn.css(durationArea, {
                    display: 'flex',
                    width: '98%',
                    position: 'absolute',
                    left: '1%',
                    right: '1%',
                    bottom: '5px',
                    'z-index': 99999,
                    'align-items': 'center',
                    'justify-content': 'space-between',
                    transition: '0.5s'
                });
                progress.style.bottom = '0px';
                !isMenu;
            } else {
                return false;
            }
        }

        function getSpeedIndex(items, i) {
            for (let l = 0; l < items.length; l++) {
                if (items[l] == i) {
                    return items[l]
                }
            }
        }

        function getQualityIndex(items, i) {
            for (let l = 0; l < items.length; l++) {
                if (items[l] == i) {
                    return l;
                }
            }
        }

        function scrubibing(e) {
            let sTime = 0;
            let times = Math.round(e.offsetX);
            const rect = progress.getBoundingClientRect();
            const percent = e.x - rect.x;
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                let myVideo = video;
                if(absPlayer.v360){
                    myVideo = video360;
                }
                sTime = myVideo.duration != NaN && myVideo.duration != null && myVideo.duration != undefined ? (percent * myVideo.duration) / progress.offsetWidth : 0;
            } else if (playername == 'youtube') {
                sTime = percent * currentEvent.duration / progress.offsetWidth;
            } else if (playername == 'vimeo') {
                sTime = (percent * vmDuration) / progress.offsetWidth;
            }
            progress.style.height = "6px";
            progressTooltip.style.zIndex = 999;
            progressTooltip.style.marginLeft = (times - (progressTooltip.offsetWidth / 3)) + "px";
            if (isLive) {
                def.fn.html(progressTooltip, "00:00");
            } else {
                def.fn.html(progressTooltip, formatDuration(sTime));
            }
        }


        function toggleScrubbing(e) {
            if (!isLive) {
                const rect = progress.getBoundingClientRect();
                const percent = e.x - rect.x;

                if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                    let myVideo = video;
                    if(absPlayer.v360){
                        myVideo = video360;
                    }
                    myVideo.currentTime = (percent * myVideo.duration) / progress.offsetWidth;
                } else if (playername == 'youtube') {
                    youtubePlayer.seekTo(percent * currentEvent.duration / progress.offsetWidth, true)
                } else if (playername == 'vimeo') {
                    vmPlayer.setCurrentTime((percent * vmDuration) / progress.offsetWidth);
                }
            }
        }


        function getFullDuration() {
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                if (absPlayer.v360) {
                    durationText.innerHTML = formatDuration(video360.duration);
                    maxDuration = video360.duration;
                } else {
                    durationText.innerHTML = formatDuration(video.duration);
                    maxDuration = video.duration;
                }
            } else if (playername == 'youtube') {
                durationText.innerHTML = formatDuration(currentEvent.duration);
                maxDuration = currentEvent.duration;
            } else if (playername == 'vimeo') {
                durationText.innerHTML = formatDuration(vmDuration);
                maxDuration = vmDuration;
            }
        }

        function nextDuration() {
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                let myVideo = video;
                if(absPlayer.v360){
                    myVideo = video360;
                }
                return myVideo.duration;
            } else if (playername == 'youtube') {
                return currentEvent.duration;
            } else if (playername == 'vimeo') {
                return vmDuration;
            }
        }

        function getCurrentDuration() {
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                let myVideo = video;
                if(absPlayer.v360){
                    myVideo = video360;
                }

                durationCurrent.innerHTML = formatDuration(myVideo.currentTime);
                var size = parseInt(
                    (myVideo.currentTime * progress.offsetWidth) / myVideo.duration
                );
                currentDuration = Math.ceil(myVideo.currentTime);
                progressTimeline.style.width = size + "px";
                
            }
            if (playername == 'youtube') {
                durationCurrent.innerHTML = formatDuration(parseInt(currentEvent.currentTime));
                var size = parseInt(
                    (currentEvent.currentTime * progress.offsetWidth) / currentEvent.duration
                );
                currentDuration = parseInt(currentEvent.currentTime);
                progressTimeline.style.width = size + "px";
            }
            if (playername == 'vimeo') {
                var size = parseInt((vmCurrentTime * progress.offsetWidth) / vmDuration);
                progressTimeline.style.width = size + "px";
                currentDuration = Math.ceil(vmCurrentTime);
            }

            if (Math.ceil(maxDuration) != Math.ceil(nextDuration()) || isLive == true) {
                def.fn.html(durationText, "<span style='color:red'>●</span> <span style='font-size:12px;color:orange'>LIVE</span>");
            }

            if (currentDuration >= 1) {
                removePoster();
            }
        }

        function getBuffer() {
            const duration = currentEvent.duration;
            if (duration > 0 && playername == 'youtube') {
                progressBuffer.style.width = parseInt(currentEvent.currentTime * progress.offsetWidth) / currentEvent.duration + currentEvent.buffer + "px"

            }
        }

        function handleTimelineUpdate(e) {
            const rect = timelineContainer.getBoundingClientRect();
            const percent =
                Math.min(Math.max(0, e.x - rect.x), rect.width) / rect.width;
            const previewImgNumber = Math.max(
                1,
                Math.floor((percent * video.duration) / 10)
            );
            timelineContainer.style.setProperty("--preview-position", percent);

            if (isScrubbing) {
                e.preventDefault();
                timelineContainer.style.setProperty("--progress-position", percent);
            }
        }

        const leadingZeroFormatter = new Intl.NumberFormat(undefined, {
            minimumIntegerDigits: 2,
        });

        function formatDuration(time) {
            if(!isNaN(time)){
                const seconds = Math.floor(time % 60);
                const minutes = Math.floor(time / 60) % 60;
                const hours = Math.floor(time / 3600);
                if (hours === 0) {
                    return `${minutes}:${leadingZeroFormatter.format(seconds)}`;
                } else {
                    return `${hours ?? '0'}:${leadingZeroFormatter.format(
                        minutes
                    ) ?? '00'}:${leadingZeroFormatter.format(seconds) ?? '00'}`;
                }
            }else{
                return '0:00';
            }
        }

        function seekBackward() {
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                let myVideo = video;
                if(absPlayer.v360){
                    myVideo = video360;
                }
                if (myVideo.currentTime - 15 >= 0) {
                    durationCurrent.innerHTML = formatDuration(myVideo.currentTime - 15);
                    var size = parseInt(
                        ((myVideo.currentTime - 15) * progress.offsetWidth) / myVideo.duration
                    );
                    myVideo.currentTime = myVideo.currentTime - 15;
                    currentDuration = Math.ceil(myVideo.currentTime);
                    progressTimeline.style.width = size + "px";
                } else {
                    durationCurrent.innerHTML = formatDuration(0);
                    var size = parseInt(
                        (0 * progress.offsetWidth) / myVideo.duration
                    );
                    myVideo.currentTime = 0;
                    currentDuration = Math.ceil(0);
                    progressTimeline.style.width = size + "px";
                }
            }
            if (playername == 'youtube') {
                if (currentEvent.currentTime - 15 >= 0) {
                    durationCurrent.innerHTML = formatDuration(parseInt(currentEvent.currentTime - 15));
                    var size = parseInt(
                        ((currentEvent.currentTime - 15) * progress.offsetWidth) / currentEvent.duration
                    );
                    currentDuration = parseInt(currentEvent.currentTime - 15);
                    progressTimeline.style.width = size + "px";
                    youtubePlayer.seekTo(currentEvent.currentTime - 15);
                } else {
                    durationCurrent.innerHTML = formatDuration(parseInt(0));
                    var size = parseInt(
                        (0 * progress.offsetWidth) / currentEvent.duration
                    );
                    currentDuration = parseInt(0);
                    progressTimeline.style.width = size + "px";
                    youtubePlayer.seekTo(0);
                }
            }
            if (playername == 'vimeo') {
                if ((vmCurrentTime - 15) >= 0) {
                    var size = parseInt(((vmCurrentTime - 15) * progress.offsetWidth) / vmDuration);
                    progressTimeline.style.width = size + "px";
                    currentDuration = Math.ceil(vmCurrentTime - 15);
                    vmPlayer.setCurrentTime(vmCurrentTime - 15);
                } else {
                    var size = parseInt((0 * progress.offsetWidth) / vmDuration);
                    progressTimeline.style.width = size + "px";
                    currentDuration = Math.ceil(0);
                    vmPlayer.setCurrentTime(0);
                }
            }
        }

        function seekForward() {
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                let myVideo = video;
                if(absPlayer.v360){
                    myVideo = video360;
                }
                if (myVideo.currentTime + 15 <= myVideo.duration) {
                    durationCurrent.innerHTML = formatDuration(myVideo.currentTime + 15);
                    var size = parseInt(
                        ((myVideo.currentTime + 15) * progress.offsetWidth) / myVideo.duration
                    );
                    myVideo.currentTime = myVideo.currentTime + 15;
                    currentDuration = Math.ceil(myVideo.currentTime);
                    progressTimeline.style.width = size + "px";
                } else {
                    durationCurrent.innerHTML = formatDuration(myVideo.duration);
                    var size = parseInt(
                        (myVideo.duration * progress.offsetWidth) / myVideo.duration
                    );
                    myVideo.currentTime = myVideo.duration;
                    currentDuration = Math.ceil(myVideo.duration);
                    progressTimeline.style.width = size + "px";
                }
            }
            if (playername == 'youtube') {
                if (currentEvent.currentTime + 15 <= currentEvent.duration) {
                    durationCurrent.innerHTML = formatDuration(parseInt(currentEvent.currentTime + 15));
                    var size = parseInt(
                        ((currentEvent.currentTime + 15) * progress.offsetWidth) / currentEvent.duration
                    );
                    currentDuration = parseInt(currentEvent.currentTime + 15);
                    progressTimeline.style.width = size + "px";
                    youtubePlayer.seekTo(currentEvent.currentTime + 15);
                } else {
                    durationCurrent.innerHTML = formatDuration(parseInt(currentEvent.duration));
                    var size = parseInt(
                        (currentEvent.duration * progress.offsetWidth) / currentEvent.duration
                    );
                    currentDuration = parseInt(currentEvent.duration);
                    progressTimeline.style.width = size + "px";
                    youtubePlayer.seekTo(currentEvent.duration);
                }
            }
            if (playername == 'vimeo') {
                if ((vmCurrentTime + 15) <= vmDuration) {
                    var size = parseInt(((vmCurrentTime + 15) * progress.offsetWidth) / vmDuration);
                    progressTimeline.style.width = size + "px";
                    currentDuration = Math.ceil(vmCurrentTime + 15);
                    vmPlayer.setCurrentTime(vmCurrentTime + 15);
                } else {
                    var size = parseInt((vmDuration * progress.offsetWidth) / vmDuration);
                    progressTimeline.style.width = size + "px";
                    currentDuration = Math.ceil(vmDuration);
                    vmPlayer.setCurrentTime(vmDuration);
                }
            }
        }

        function setMuteicon() {
            if (isMute) {
                def.fn.html(volumeControll, def.icons.muteBtn);
            } else {
                def.fn.html(volumeControll, def.icons.soundLower);
            }
        }

        function setDefaultVolume() {
            let soundWidth = localStorage.getItem('pr_active_sound') ?? 20;
            volumeSlider.setAttribute("current", soundWidth);
            if (Math.ceil(soundWidth) > 0 && Math.ceil(soundWidth) < 50) {
                volumeControll.innerHTML = def.icons.soundLower;
            } else if (
                Math.ceil(soundWidth) > 49 &&
                Math.ceil(soundWidth) <= 100
            ) {
                volumeControll.innerHTML = def.icons.soundHigher;
            }
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                let myPlayer = video;
                if(absPlayer.v360){
                    myPlayer = video360;
                }
                myPlayer != undefined ? myPlayer.volume = soundWidth / 100 : 0;
            } else if (youtubePlayer != undefined && (isYoutube == 'yTb' | isYoutube != undefined)) {
                youtubePlayer.setVolume((soundWidth));
            } else if (vmPlayer != undefined && playername == 'vimeo') {
                vmPlayer.setVolume(soundWidth / 100);
            }
        }

        function changeVolume(number){
            const swidth = Number(localStorage.getItem('pr_active_sound')) + (number) ;
            let soundWidth = 0;
            if(swidth < 0 ){
                soundWidth = 0;
            }else if(swidth > 100){
                soundWidth = 100;         
            }else{
                soundWidth = swidth;
            }
            volumeSlider.setAttribute("current", soundWidth);

            if (Math.ceil(soundWidth) > 0 && Math.ceil(soundWidth) < 50) {
                volumeControll.innerHTML = def.icons.soundLower;
            } else if (
                Math.ceil(soundWidth) > 49 &&
                Math.ceil(soundWidth) <= 100
            ) {
                volumeControll.innerHTML = def.icons.soundHigher;
            }
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                if (absPlayer.v360) {
                    video360.volume = soundWidth / 100;
                } else {
                    video.volume = soundWidth / 100;
                }
            } else if (isYoutube == 'yTb') {
                youtubePlayer.setVolume((soundWidth));
            } else if (playername == 'vimeo') {
                vmPlayer.setVolume(soundWidth / 100);
            }
            if (isMute) {
                toggleMute();
            }
            localStorage.setItem('pr_active_sound', soundWidth);
        }

        function toggleMute() {
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                isMute == false ? video.muted = true : video.muted = false;
            } else if (youtubePlayer != undefined && (isYoutube == 'yTb' | isYoutube != undefined)) {
                isMute == false ? youtubePlayer.mute() : youtubePlayer.unMute();
            } else if (vmPlayer != undefined && (playername == 'vimeo' | isVimeo != undefined)) {
                isMute == false ? vmPlayer.setMuted(true) : vmPlayer.setMuted(false);
            }
            isMute = !isMute;
            setMuteicon();
        }

        function togglePlayPause() {
            if (isVast == false) {
                if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                    if (absPlayer.v360) {
                        if (video360.paused) {
                            video360.play();
                            isPlaying = true;
                            def.fn.html(playPauseControll, def.icons.pauseBtn);
                        } else {
                            video360.pause();
                            isPlaying = false;
                            def.fn.html(playPauseControll, def.icons.playBtn);
                        }
                    } else {
                        if (video.paused) {
                            video.play();
                            isPlaying = true;
                            def.fn.html(playPauseControll, def.icons.pauseBtn);
                        } else {
                            video.pause();
                            isPlaying = false;
                            def.fn.html(playPauseControll, def.icons.playBtn);
                        }
                    }
                    youtubeRemover();
                }
                if (playername == 'youtube') {
                    if (currentEvent.isPlaying != '1') {
                        youtubePlayer.playVideo();
                        isPlaying = true;
                        def.fn.html(playPauseControll, def.icons.pauseBtn);
                        youtubeRemover();
                    } else {
                        youtubePlayer.pauseVideo();
                        isPlaying = false;
                        controlResizer();
                        def.fn.html(playPauseControll, def.icons.playBtn);
                    }
                }
                if (playername == 'vimeo') {
                    if (vmActive == false) {
                        vmPlayer.play();
                        isPlaying = true;
                        def.fn.html(playPauseControll, def.icons.pauseBtn);
                    } else {
                        vmPlayer.pause();
                        isPlaying = false;
                        def.fn.html(playPauseControll, def.icons.playBtn)
                    }
                    youtubeRemover();
                }
            }
            setDefaultVolume();
        }

        function forcePause() {
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                let myPlayer = video;
                if(absPlayer.v360){
                    myPlayer = video360;
                }
                myPlayer != undefined ? myPlayer.pause(): '';
                isPlaying = false;
                def.fn.html(playPauseControll, def.icons.playBtn);
            }
            if (youtubePlayer != undefined && (isYoutube == 'yTb' | isYoutube != undefined)) {
                if (youtubePlayer != undefined && (isYoutube == 'yTb' | isYoutube != undefined)) {
                    youtubePlayer.pauseVideo();
                    isPlaying = false;
                    def.fn.html(playPauseControll, def.icons.playBtn);
                }
            }
            if (vmPlayer != undefined && (playername == 'vimeo' | isVimeo != undefined)) {
                vmPlayer.pause();
                isPlaying = false;
                def.fn.html(playPauseControll, def.icons.playBtn)
            }
            setDefaultVolume();
        }

        function forcePlay() {
            if (playername == 'mp4' | playername == 'hls' | playername == 'dash' | playername == 'flv' | playername == 'mkv') {
                let myPlayer = video;
                if(absPlayer.v360){
                    myPlayer = video360;
                }
                myPlayer.play();
                def.fn.html(playPauseControll, def.icons.pauseBtn);
            }
            if (youtubePlayer != undefined && (isYoutube == 'yTb' | isYoutube != undefined)) {
                youtubePlayer.playVideo();
                def.fn.html(playPauseControll, def.icons.pauseBtn);
            }
            if (vmPlayer != undefined && (playername == 'vimeo' | isVimeo != undefined)) {
                vmPlayer.play();
                def.fn.html(playPauseControll, def.icons.pauseBtn)
            }
            isPlaying = true;
            setDefaultVolume();
        }

        function setcallBack(item, callback, aftercallback = null) {
            item.addEventListener("mouseenter", () => {
                item.style.background = "rgba(0,0,0,0.6)";
                item.style.color = "orange";
                item.style.borderRadius = '4px';
                item.style.paddingLeft = '4px';
                item.style.transition = '0.1s'
            });
            item.addEventListener("mouseleave", () => {
                item.style.background = "none";
                item.style.color = "#fff";
                item.style.borderRadius = '0px';
                item.style.paddingLeft = '0px';
                item.style.transition = '0.1s'
            });
            item.addEventListener("mouseover", () => {
                item.style.background = "rgba(0,0,0,0.6)";
                item.style.color = "orange";
                item.style.borderRadius = '4px';
                item.style.paddingLeft = '4px';
                item.style.transition = '0.1s'
            });
            item.addEventListener("click", () => {
                callback(item);
            });

            if (aftercallback != null) {
                aftercallback(item);
            }
        }


        function addPoster() {
            youtubeClick.style.background = `url('${absPlayer.poster}') no-repeat center`;
            youtubeClick.style.backgroundSize = 'cover';
        }

        function removePoster() {
            youtubeClick.style.background = `transparent`;
        }


        window.addEventListener('keydown', (e) => {
            console.log(e.key);
            switch (e.key) {
                case 'f':
                    toggleFullscreen();
                    break;
                case 'm':
                    toggleMute();
                    break;
                case ' ':
                    togglePlayPause();
                    break;
                case 'p':
                    togglePlaylist();
                    break;
                case 's':
                    toggleShare();
                    break;
                case 'ArrowRight':
                    seekForward();
                    break;
                case 'ArrowLeft':
                    seekBackward();
                    break;
                case 'ArrowUp':
                    changeVolume(15);
                    break;
                case 'ArrowDown':
                    changeVolume(-15);
                    break;
                case 'Enter':
                    toggleFullscreen();
                    break;
            }
        })

        function getFileInfo() {
            const nvideo = ['mp4', 'webm', 'ogg', 'm3u8', 'mpd'];
            if (nvideo.indexOf(fileExtention) >= 0) {
                return 'video';
            } else if (isYoutube == "yTb") {
                return 'youtube'
            }
        }

        function typeGenerator(ext) {
            if (ext == "mp4") {
                return "video/mp4";
            } else if (ext == "webm") {
                return "video/webm";
            } else if (ext == "ogg") {
                return "video/ogg";
            } else if (ext == 'mkv') {
                return "video/x-matroska";
            } else if (ext == "m3u8") {
                return "application/x-mpegURL";
            } else if (ext == "mpd") {
                return "application/vnd.apple.mpegurl";
            }
        }
        function extractFacebookID(url) {
            const regex =
                /(?:https?:)?(?:\/\/)?(?:[0-9A-Z-]+\.)?(?:facebook)?\.com\/(?:\S+)(?:v=|videos\/|%2Fvideos%2F)(\d+)/;
            const newValue = url.match(regex);
            setTimeout(() => {
                if (regex.test(url)) {
                    return newValue[1];
                }
            }, 300);
        }

        function extChecker(indexFile) {
            var url;
            if (encrypt == true) {
                url = atob(indexFile);
            } else {
                url = indexFile;
            }
            var exts = url.substring(url.lastIndexOf(".") + 1);
            var ext = exts.slice(0, 4).toLowerCase();
            if (ext == 'm3u8') {
                return 'm3u8';
            } else if (ext == 'webm') {
                return 'webm';
            } else {
                switch (ext.slice(0, 3)) {
                    case 'mp4':
                        return 'mp4';
                    case 'ogg':
                        return 'ogg';
                    case 'avi':
                        return 'avi';
                    case 'mkv':
                        return 'mkv';
                    case 'mp3':
                        return 'mp3';
                    case 'wav':
                        return 'wav';
                    case 'm3u':
                        return 'm3u';
                    case 'mpd':
                        return 'mpd';
                    case 'xml':
                        return 'xml';
                    case 'flv':
                        return 'flv';
                    default:
                        return false;
                }
            }
        }

        function isEncrypt($url) {
            return atob($url)
        }

        function driveGenerator(fileURL) {
            let fileURI = fileURL[0];
            if (fileURI.indexOf("drive") > -1) {
                return "dLINK";
            } else {
                return "Your video format in not supported!";
            }
        }

        function youtubedl(fileURL) {
            let fileURI = fileURL[0];
            if (fileURI.indexOf("googlevideo.com") > -1) {
                return "yTDL";
            } else {
                return "Your video format in not supported!";
            }
        }

        function APIYoutube(fileURL) {
            let fileURI;
            if (encrypt == true) {
                fileURI = atob(fileURL);
            } else {
                fileURI = fileURL;
            }
            if (
                fileURI.indexOf("youtube.com") > -1 ||
                fileURI.indexOf("youtu.be") > -1
            ) {
                const regex =
                    /(?:https?:)?(?:\/\/)?(?:[0-9A-Z-]+\.)?(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/\S*?[^\w\s-])((?!videoseries)[\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:['"][^<>]*>|<\/a>))[?=&+%\w.-]*/;
                const newValue = fileURI.match(regex);
                return "yTb";
            } else {
                return "fail";
            }
        }

        function APIVimeo(fileURI) {
            var url;
            if (encrypt == true) {
                url = atob(fileURI);
            } else {
                url = fileURI;
            }
            if (url.indexOf("vimeo.com") > -1) {
                const last = url.split('/');
                const vimeoURLID = last[last.length - 1];
                return vimeoURLID;
            } else {
                return false;
            }
        }

        async function loadScript(src) {
            return new Promise((resolve, reject) => {
                const script = document.createElement("script");
                script.type = "text/javascript";
                script.onload = () => {
                    resolve();
                };
                script.onerror = () => {
                    console.log("Failed to load script", src);
                    reject();
                };
                script.src = src;
                document.head.appendChild(script);
            });
        }

        function isMobile() {
            var check = false;
            (function (a) { if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true })(navigator.userAgent || navigator.vendor || window.opera);
            return check;
        }

        function controlResizer() {
            let documents = document.querySelector('body');
            if (documents.offsetWidth < 667 && playername == 'youtube' && isPlaying) {
                topControls.style.height = '0px';
                bottomControls.style.height = '0px';
            } else {
                if (!isPlaying && playername == 'youtube') {
                    topControls.style.height = '58px';
                    bottomControls.style.height = '58px';
                }
            }
        }

        function youtubeRemover() {
            topControls.style.height = '0px';
            bottomControls.style.height = '0px';
        }

        window.addEventListener('load', () => {
            controlResizer();
        })

        window.addEventListener('resize', () => {
            controlResizer();
        })

        function rightOptions(item, container) {
            isPlayFalse = true;
            class ContextMenu {
                constructor({ target = null, menuItems = [], mode = null, box = null }) {
                    this.target = target;
                    this.menuItems = menuItems;
                    this.mode = mode;
                    this.box = box;
                    this.targetNode = this.getTargetNode();
                    this.menuItemsNode = this.getMenuItemsNode();
                    this.isOpened = false;
                }

                getTargetNode() {
                    const nodes = this.box.querySelectorAll(this.target);
                    if (nodes && nodes.length !== 0) {
                        return nodes;
                    } else {
                        console.error(`getTargetNode :: "${this.target}" target not found`);
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
                        const item = this.createItemMarkup(data);
                        item.firstChild.setAttribute(
                            "style",
                            `animation-delay: ${index * 0.08}s`
                        );
                        nodes.push(item);
                    });

                    return nodes;
                }

                createItemMarkup(data) {
                    const button = document.createElement("BUTTON");
                    const item = document.createElement("LI");

                    button.innerHTML = data.content;
                    button.classList.add("contextMenu-button");
                    item.classList.add("contextMenu-item");

                    if (data.divider) item.setAttribute("data-divider", data.divider);
                    item.appendChild(button);

                    if (data.events && data.events.length !== 0) {
                        Object.entries(data.events).forEach((event) => {
                            const [key, value] = event;
                            button.addEventListener(key, value);
                        });
                    }

                    return item;
                }

                renderMenu() {
                    const menuContainer = document.createElement("UL");

                    menuContainer.classList.add("contextMenu");
                    menuContainer.setAttribute("data-theme", this.mode);

                    this.menuItemsNode.forEach((item) => menuContainer.appendChild(item));

                    return menuContainer;
                }

                closeMenu(menu) {
                    if (this.isOpened) {
                        this.isOpened = false;
                        isPlayFalse = false;
                        menu.remove();
                    }
                }

                init() {
                    const contextMenu = this.renderMenu();
                    document.addEventListener("click", () => this.closeMenu(contextMenu));
                    window.addEventListener("blur", () => this.closeMenu(contextMenu));
                    document.addEventListener("contextmenu", (e) => {
                        this.targetNode.forEach((target) => {
                            if (!e.target.contains(target)) {
                                contextMenu.remove();
                            }
                        });
                    });

                    this.targetNode.forEach((target) => {
                        target.addEventListener("contextmenu", (e) => {
                            e.preventDefault();
                            this.isOpened = true;

                            const { clientX, clientY } = e;
                            this.box.appendChild(contextMenu);
                            const positionY =
                                clientY + contextMenu.scrollHeight >= window.innerHeight
                                    ? window.innerHeight - contextMenu.scrollHeight - 20
                                    : clientY;
                            const positionX =
                                clientX + contextMenu.scrollWidth >= window.innerWidth
                                    ? window.innerWidth - contextMenu.scrollWidth - 20
                                    : clientX;

                            contextMenu.setAttribute(
                                "style",
                                `--width: ${contextMenu.scrollWidth}px;
                              --height: ${contextMenu.scrollHeight}px;
                              --top: ${positionY}px;
                              --left: ${positionX}px;
                              --z-index: 999999999`

                            );
                        });
                    });
                }
            }

            const hostURL = "https://abdursoft.com/";
            const menuItems = [
                {
                    content: `ABS Video Player`,
                    events: {
                        click: (e) => {
                            window.open(hostURL + "abs-player", "_blank");
                        },
                    },
                },
                {
                    content: `ABS Radio Player`,
                    events: {
                        click: (e) => {
                            window.open('https://live-radio.top/documentation', "_blank");
                        },
                    },
                },
                {
                    content: `Documentation`,
                    events: {
                        click: (e) => {
                            window.open(hostURL, '_blank');
                        }
                    },
                },
                {
                    content: `Version 1.0.5`,
                    divider: "top", // top, bottom, top-bottom
                },
            ];

            const dark = new ContextMenu({
                target: item,
                menuItems,
                mode: 'dark',
                box: container
            });
            dark.init();
            function removeMessage() {
                const message = container.querySelector(".right-click");
                if (message) message.remove();
            }
            window.addEventListener("click", removeMessage);
            window.addEventListener("contextmenu", removeMessage);
        }

        return {
            new: (url) => {
                __init(url);
            }
        }
    };
})($);