FROM nginx:alpine
RUN mkdir -p /etc/nginx/ssl
#COPY nginx.crt /etc/nginx/ssl/nginx.crt
#COPY nginx.key /etc/nginx/ssl/nginx.key
COPY default.conf /etc/nginx/conf.d/default.conf

EXPOSE 80 
CMD ["nginx", "-g", "daemon off;"]