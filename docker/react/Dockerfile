# pull official base image
FROM node:17-alpine

# set working directory
WORKDIR /app

# add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# install app dependencies
COPY ./front/package.json ./
COPY ./front/yarn.lock ./
RUN yarn install
RUN yarn global add react-scripts

# add app
COPY ./front/ ./

# start app
CMD ["yarn", "start"]
