

    <script type="text/javascript" src="js/jquery.min.js"></script>
      <script type="text/javascript" src="js/plugins.js"></script>
      <script type="text/javascript" src="js/scripts.js"></script>

      <script type="text/javascript" src="js/ovac4u/jquery.prettyPhoto.js"></script>
      <script type="text/javascript" src="js/ovac4u/owl.carousel.js"></script>
      <script type="text/javascript" src="js/ovac4u/vegas.js"></script>
      <script type="text/javascript" src="js/ovac4u/instafeed.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/pagemap/dist/pagemap.min.js"></script>
      <script src="https://embed.typeform.com/embed.js"></script>

      <script>
          pagemap(document.querySelector('#map'));
      </script>
      <script>
        $(document).ready(function() {
          var userid = 253601294,
            access_token = "253601294.1677ed0.f92b1909bb5b47ed9d9a2f0718b86d7a",
            count = 5;

          var feed = new Instafeed({

            mock: true,
            get: 'user',
            userId: userid,
            sortBy: 'random',
            accessToken: access_token,

            success: function(response) {
              var slides = response.data.map(function(obj) {
                var rObj = {};
                rObj["src"] = obj.images.standard_resolution.url;
                return rObj;
              });

              $('.bg._main').vegas({
                slides: slides,
                shuffle: true,
                transition: 'blur2',
                align: 'middle',
                overlay: '/css/overlays/08.png'
              });
            }

          });

          feed.run();

          var el = document.getElementById('typeform-contact-widget');

          typeformEmbed.makeWidget(el, "https://ovac4u.typeform.com/to/vEAuJS", {
              opacity: 50,
              hideFooter: true,
              hideHeaders: true,
              onSubmit: gtag_report_conversion,
          });
        });
      </script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.2/angular.min.js"></script>
      <script type="text/javascript" src="https://www.ovac4u.com/blogs/public/ghost-sdk.min.js?v=701f1fcbc3"></script>

      <script>
        ghost.init({
          clientId: "ghost-frontend",
          clientSecret: "29f95c51d526"
        });


        angular.module('ovac4u.com', [])

          .controller('BlogController', function($http, $scope){

              var vm = this;

              $http.get(ghost.url.api('posts', {
                limit: 3,
                format: 'string',
                fields: 'feature_image,title,date,url'
              })).then(function (response){
                vm.data = response.data;
              });

          });
      </script>
      <!-- script src="//www.pocket-locator.com/api/?k=872f7da0c11af571170712d87880fc38&f=js&id=location" async defer></script -->
      <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-599a2b3ed56dd5f2"></script>

      <script type="text/javascript">
          (function () {
              var head = document.getElementsByTagName("head").item(0);
              var script = document.createElement("script");

              var src = (document.location.protocol == 'https:'
                  ? 'https://www.formilla.com/scripts/feedback.js'
                  : 'http://www.formilla.com/scripts/feedback.js');

              script.setAttribute("type", "text/javascript");
              script.setAttribute("src", src); script.setAttribute("async", true);

              var complete = false;

              script.onload = script.onreadystatechange = function () {
                  if (!complete && (!this.readyState
                          || this.readyState == 'loaded'
                          || this.readyState == 'complete')) {
                      complete = true;
                      Formilla.guid = 'cse50dc0-1ed7-4ea1-85f3-bdf8f2425836';
                      Formilla.loadWidgets();
                  }
              };

              head.appendChild(script);
          })();
      </script>

      <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TWFSSDL');</script>
        <!-- End Google Tag Manager -->
        <!-- Google Analytics -->
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-104991685-1', 'auto');
        ga('send', 'pageview');
      </script>
      <!-- End Google Analytics -->
