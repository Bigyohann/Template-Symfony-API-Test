# Stage 0, "build-stage", based on Node.js, to build and compile the frontend
FROM node:17-alpine AS build-stage

WORKDIR /app

COPY ./front/package*.json /app/

RUN yarn install

COPY ./front/ /app/

RUN yarn build
# Stage 1, based on Nginx, to have only the compiled app, ready for production with Nginx
FROM nginx:alpine AS prod-stage

COPY --from=build-stage /app/build/ /usr/share/nginx/html

COPY ./docker/front/prod/default.conf /etc/nginx/conf.d/default.conf
