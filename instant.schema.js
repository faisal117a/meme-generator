import { i } from "@instantdb/react";

const schema = i.schema({
  entities: {
    memes: i.entity({
      imageData: i.string(),
      title: i.string().optional(),
      authorId: i.string(),
      authorEmail: i.string(),
      createdAt: i.number(),
    }).permissions({
      read: true, // Everyone can read memes
      create: (ctx) => ctx.auth.id !== null, // Only authenticated users can create
      update: (ctx, entity) => ctx.auth.id === entity.authorId, // Only author can update
      delete: (ctx, entity) => ctx.auth.id === entity.authorId, // Only author can delete
    }),
    upvotes: i.entity({
      memeId: i.string(),
      userId: i.string(),
      createdAt: i.number(),
    }).permissions({
      read: true, // Everyone can read upvotes
      create: (ctx) => ctx.auth.id !== null, // Only authenticated users can create upvotes
      update: false, // Upvotes cannot be updated
      delete: (ctx, entity) => ctx.auth.id === entity.userId, // Users can delete their own upvotes
    }),
  },
});

export default schema;

