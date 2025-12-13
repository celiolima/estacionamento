FROM nginx:alpine
RUN mkdir -p /etc/nginx/ssl
#COPY nginx.crt /etc/nginx/ssl/nginx.crt
#COPY nginx.key /etc/nginx/ssl/nginx.key
COPY default.conf /etc/nginx/conf.d/default.conf
COPY default.template.conf /etc/nginx/conf.d/default.template
EXPOSE ${NGINX_PORT} 
CMD ["nginx", "-g", "daemon off;"]